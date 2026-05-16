<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DevicesController extends Controller
{
    public function index()
    {
        $devices = Device::orderByDesc('last_seen_at')->paginate(15);
        return view('devices.index', compact('devices'));
    }

    public function create()
    {
        return view('devices.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label'  => 'required|string|max:100',
            'uuid'   => 'required|string|unique:devices,uuid|max:255',
            'zone'   => 'nullable|string|max:100',
            'status' => 'required|in:0,1',
            'rssi' => 'nullable|integer',
            'wifi_username' => 'nullable|string|max:100',
            'wifi_password' => 'nullable|string|max:100',
        ]);

        Device::create($validated);

        return redirect()->route('devices.index')->with('success', 'Device added successfully.');
    }

    public function edit(Device $device)
    {
        return view('devices.edit', compact('device'));
    }

    public function update(Request $request, Device $device)
    {
        $request->merge(['status' => (string) $request->status]);
        $validated = $request->validate([
            'label'  => 'required|string|max:100',
            'uuid'   => 'required|string|max:255|unique:devices,uuid,' . $device->id,
            'zone'   => 'nullable|string|max:100',
            'status' => 'required|in:0,1',
            'rssi' => 'nullable|integer',
            'wifi_username' => 'nullable|string|max:100',
            'wifi_password' => 'nullable|string|max:100',
        ]);

        $device->update($validated);

        return redirect()->route('devices.index')->with('success', 'Device updated successfully.');
    }

    public function destroy(Device $device)
    {
        $device->delete();
        return redirect()->route('devices.index')->with('success', 'Device deleted.');
    }
}