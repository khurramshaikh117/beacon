<?php

namespace App\Console\Commands;

use App\Models\PresenceLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MarkStalePresenceOut extends Command
{
    protected $signature = 'presence:mark-stale-out {--minutes=5 : Minutes without a new IN before marking OUT}';

    protected $description = 'Insert OUT presence logs for members whose last IN is older than the threshold';

    public function handle(): int
    {
        $threshold = Carbon::now()->subMinutes((int) $this->option('minutes'));
        $marked    = 0;

        User::trackedMembers()
            ->with('latestPresence')
            ->each(function (User $user) use ($threshold, &$marked) {
                $latest = $user->latestPresence;

                if (!$latest || $latest->status !== PresenceLog::STATUS_IN) {
                    return;
                }

                if ($latest->created_at->gte($threshold)) {
                    return;
                }

                PresenceLog::create([
                    'device_uuid' => $latest->device_uuid,
                    'user_uuid'   => $user->user_uuid,
                    'zone'        => $latest->zone,
                    'rssi'        => $latest->rssi,
                    'status'      => PresenceLog::STATUS_OUT,
                ]);

                $marked++;
            });

        $this->info("Members marked OUT: {$marked}");

        return self::SUCCESS;
    }
}
