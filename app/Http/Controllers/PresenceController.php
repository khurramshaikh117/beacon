<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Device;
use Carbon\Carbon;

class PresenceController extends Controller
{
   
    public function store(Request $request)
    {
        // 1. Validate input (MVP-safe)
        $validated = $request->validate([
            'uuid'  => 'required|string',
            'event' => 'required|in:IN,OUT',
            'rssi'  => 'nullable|integer',
        ]);

        // 2. Find or create device by UUID
        $device = Device::firstOrCreate(
            ['uuid' => $validated['uuid']],
            [
                'status'        => $validated['event'],
                'rssi'          => $validated['rssi'] ?? null,
                'last_seen_at'  => Carbon::now(),
            ]
        );

        // 3. If device already existed → update it
        if (!$device->wasRecentlyCreated) {
            $device->update([
                'status'        => $validated['event'],
                'rssi'          => $validated['rssi'] ?? $device->rssi,
                'last_seen_at'  => Carbon::now(),
            ]);
        }

        // 4. Return minimal response (ESP32 friendly)
        return response()->json([
            'success' => true,
            'uuid'    => $device->uuid,
            'status'  => $device->status,
        ]);
    }
}
