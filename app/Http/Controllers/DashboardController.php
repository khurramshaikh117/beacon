<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\User;
use App\Models\PresenceLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    private const DEVICE_ONLINE_MINUTES = 5;

    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));
        $today  = Carbon::today();
        $onlineSince = Carbon::now()->subMinutes(self::DEVICE_ONLINE_MINUTES);

        // ── Stats ─────────────────────────────────────────────
        $devicesOnline = Device::where('status', 1)
            ->where('last_seen_at', '>=', $onlineSince)
            ->count();

        $totalMembers = User::trackedMembers()->count();

        // Members present = latest presence log today is IN (1001)
        $membersIn = User::trackedMembers()
            ->whereHas('latestPresence', function ($q) use ($today) {
                $q->whereDate('created_at', $today)
                  ->where('status', PresenceLog::STATUS_IN);
            })->count();

        $membersOut = $totalMembers - $membersIn;

        $stats = [
            'devices_online' => $devicesOnline,
            'total_members'  => $totalMembers,
            'members_in'     => $membersIn,
            'members_out'    => $membersOut,
        ];

        // ── Member table ───────────────────────────────────────
        $query = User::trackedMembers()
            ->with(['latestPresence.device'])
            ->orderBy('name');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('user_uuid', 'like', "%{$search}%");
            });
        }

        $members = $query->paginate(10)->withQueryString();

        // ── Effective hours per member today ──────────────────
        $effectiveHours = [];
        foreach ($members as $member) {
            $logs = PresenceLog::where('user_uuid', $member->user_uuid)
                ->whereDate('created_at', $today)
                ->orderBy('created_at')
                ->get();

            $effective = 0;
            $gross     = 0;
            $firstIn   = null;
            $lastSeen  = null;
            $lastIn    = null;

            foreach ($logs as $log) {
                if ($log->status === PresenceLog::STATUS_IN) {
                    $lastIn = $log->created_at;
                    if (!$firstIn) {
                        $firstIn = $log->created_at;
                    }
                } elseif ($log->status === PresenceLog::STATUS_OUT && $lastIn) {
                    $effective += $lastIn->diffInMinutes($log->created_at);
                    $lastIn = null;
                }
                $lastSeen = $log->created_at;
            }

            if ($lastIn) {
                $effective += $lastIn->diffInMinutes(Carbon::now());
            }

            if ($firstIn && $lastSeen) {
                $gross = $firstIn->diffInMinutes($lastSeen);
            }

            $effectiveHours[$member->user_uuid] = [
                'effective' => $this->formatMinutes($effective),
                'gross'     => $this->formatMinutes($gross),
            ];
        }

        return view('dashboard', compact('stats', 'members', 'effectiveHours', 'search'));
    }

    private function formatMinutes(int $minutes): string
    {
        $h = intdiv($minutes, 60);
        $m = $minutes % 60;

        return "{$h}h {$m}m";
    }
}
