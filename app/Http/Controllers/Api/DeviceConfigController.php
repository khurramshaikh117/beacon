<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\JsonResponse;

class DeviceConfigController extends Controller
{
    public function show(string $uuid): JsonResponse
    {
        $device = Device::where('uuid', $uuid)->where('status', 1)->first();

        if (!$device) {
            return response()->json([
                'success' => false,
                'message' => 'Device not found or inactive.',
            ], 404);
        }

        return response()->json([
            'success'       => true,
            'uuid'          => $device->uuid,
            'label'         => $device->label,
            'zone'          => $device->zone,
            'rssi'          => $device->rssi,
            'wifi_username' => $device->wifi_username,
            'wifi_password' => $device->wifi_password,
        ]);
    }
}