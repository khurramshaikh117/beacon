@extends('layouts.app')
@section('title', 'Add Device — ZAVI')

@section('content')

<div class="mb-4">
    <a href="{{ route('devices.index') }}" class="text-muted small text-decoration-none">
        <i class="bi bi-arrow-left me-1"></i> Back to Devices
    </a>
    <h1 class="h3 fw-bold mt-2 mb-0">Add Device</h1>
</div>

<div class="card border-0 shadow-sm" style="max-width: 600px;">
    <div class="card-body p-4">

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('devices.store') }}" method="POST">
            @csrf

            {{-- Label --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Label <span class="text-danger">*</span></label>
                <input type="text" name="label" value="{{ old('label') }}"
                       class="form-control @error('label') is-invalid @enderror"
                       placeholder="e.g. ESP32-Desk1">
                @error('label')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- UUID --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">UUID <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="text" name="uuid" id="uuid" value="{{ old('uuid') }}"
                           class="form-control @error('uuid') is-invalid @enderror"
                           placeholder="e.g. 550e8400-e29b-41d4-a716-446655440000">
                    <button type="button" class="btn btn-outline-secondary" onclick="generateUUID()">
                        <i class="bi bi-arrow-clockwise"></i> Generate
                    </button>
                    @error('uuid')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-text">Must match the UUID flashed on the physical device.</div>
            </div>

            {{-- Zone --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Zone</label>
                <input type="text" name="zone" value="{{ old('zone') }}"
                       class="form-control @error('zone') is-invalid @enderror"
                       placeholder="e.g. Cubicle 1, Reception, Zone A">
                @error('zone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- RSSI Threshold --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">RSSI Threshold</label>
                <div class="input-group">
                    <input type="number" name="rssi" value="{{ old('rssi') }}"
                        class="form-control @error('rssi') is-invalid @enderror"
                        placeholder="e.g. -70">
                    <span class="input-group-text">dBm</span>
                    @error('rssi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-text">Minimum signal strength for the ESP32 to register presence.</div>
            </div>

            {{-- WiFi Username --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">WiFi Username</label>
                <input type="text" name="wifi_username" value="{{ old('wifi_username') }}"
                    class="form-control @error('wifi_username') is-invalid @enderror"
                    placeholder="e.g. office_wifi">
                @error('wifi_username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- WiFi Password --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">WiFi Password</label>
                    <div class="input-group">
                        <input type="password" name="wifi_password" id="wifi_password"
                            value="{{ old('wifi_password', $device->wifi_password ?? '') }}"
                            class="form-control @error('wifi_password') is-invalid @enderror"
                            placeholder="Enter WiFi password">
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                            <i class="bi bi-eye" id="eye-icon"></i>
                        </button>
                        @error('wifi_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            {{-- Status --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-select @error('status') is-invalid @enderror">
                    <option value="1" {{ old('status', '1') === '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-dark px-4">Save Device</button>
                <a href="{{ route('devices.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>

        </form>
    </div>
</div>

@push('scripts')
<script>
    function generateUUID() {
        const uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            const r = Math.random() * 16 | 0;
            const v = c === 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
        document.getElementById('uuid').value = uuid;
    }

    function togglePassword() {
        const input = document.getElementById('wifi_password');
        const icon  = document.getElementById('eye-icon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }
</script>
@endpush

@endsection