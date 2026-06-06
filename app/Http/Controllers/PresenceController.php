<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\User;
use App\Models\PresenceLog;
use Carbon\Carbon;

class PresenceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'uuid'   => 'required|string',
            'event'  => 'required|in:IN,OUT',
            'rssi'   => 'nullable|integer',
            'device' => 'required|string',
            'zone'   => 'nullable|string',
        ]);

        $mobileUuid = $request->uuid;
        $deviceUuid = $request->device;
        $event      = $request->event;
        $rssi       = $request->rssi;
        $zone       = $request->zone;
        $status     = $event === 'IN' ? PresenceLog::STATUS_IN : PresenceLog::STATUS_OUT;
        $now        = Carbon::now();

        $device = Device::where('uuid', $deviceUuid)->where('status', 1)->first();

        if (!$device) {
            return response()->json([
                'success' => false,
                'message' => 'Device not found or inactive.',
            ], 404);
        }

        if (empty($zone)) {
            $zone = $device->zone ?? null;
        }

        $device->update([
            'last_seen_at' => $now,
        ]);

        $user = User::where('user_uuid', $mobileUuid)->first();

        PresenceLog::create([
            'device_uuid' => $deviceUuid,
            'user_uuid'   => $mobileUuid,
            'zone'        => $zone,
            'rssi'        => $rssi,
            'status'      => $status,
        ]);

        return response()->json([
            'success' => true,
            'uuid'    => $mobileUuid,
            'user'    => $user?->name ?? 'Unknown',
            'zone'    => $zone,
            'status'  => $event,
        ]);
    }
}
