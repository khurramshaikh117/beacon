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

        $mobileUuid = $request->uuid;    // mobile iBeacon UUID = employee
        $deviceUuid = $request->device;  // ESP32 UUID
        $event      = $request->event;
        $rssi       = $request->rssi;
        $zone       = $request->zone;
        $status     = $event === 'IN' ? 1001 : 1002;
        $now        = Carbon::now();

        // 1. Look up ESP32 device — get zone if not in payload
        $device = Device::where('uuid', $deviceUuid)->first();
        if ($device && empty($zone)) {
            $zone = $device->zone ?? null;
        }

        // 2. Update ESP32 device last seen
        if ($device) {
            $device->update([
                'last_seen_at' => $now,
            ]);
        }

        // 3. Look up employee by user_uuid = mobile beacon UUID
        $user = User::where('user_uuid', $mobileUuid)->first();

        // 4. Write to presence_logs
        PresenceLog::create([
            'device_uuid' => $deviceUuid,
            'user_uuid'   => $mobileUuid,
            'zone'        => $zone,
            'rssi'        => $rssi,
            'status'      => $status,
        ]);

        // 5. Return response
        return response()->json([
            'success' => true,
            'uuid'    => $mobileUuid,
            'user'    => $user?->name ?? 'Unknown',
            'zone'    => $zone,
            'status'  => $event,
        ]);
    }
}