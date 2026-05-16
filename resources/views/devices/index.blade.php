@extends('layouts.app')
@section('title', 'Manage Devices — ZAVI')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Manage Devices</h1>
        <p class="text-muted mb-0 small">Register and manage all ZAVI devices</p>
    </div>
    <a href="{{ route('devices.create') }}" class="btn btn-dark">
        <i class="bi bi-plus-lg me-1"></i> Add Device
    </a>
</div>

{{-- Flash Messages --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Table --}}
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Label</th>
                        <th>UUID</th>
                        <th>Zone</th>
                        <th>RSSI</th>
                        <th>WiFi User</th>
                        <th>WiFi Password</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($devices as $device)
                    <tr>
                        <td class="text-muted small">{{ $loop->iteration }}</td>
                        <td class="fw-semibold">{{ $device->label ?? '—' }}</td>
                        <td>
                            <span class="font-monospace small text-muted">{{ $device->uuid }}</span>
                        </td>
                        <td>{{ $device->zone ?? '—' }}</td>
                        <td>{{ $device->rssi ? $device->rssi . ' dBm' : '—' }}</td>
                        <td>{{ $device->wifi_username ?? '—' }}</td>
                        <td>
                            @if($device->wifi_password)
                                <span class="font-monospace">••••••••</span>
                            @else
                                —
                            @endif
                        </td>
                        <td>
                          @if($device->status == 1)
                                <span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('devices.edit', $device->id) }}" class="btn btn-sm btn-outline-secondary me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('devices.destroy', $device->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this device?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            No devices registered yet. <a href="{{ route('devices.create') }}">Add one</a>.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
            <small class="text-muted">
                Showing {{ $devices->firstItem() ?? 0 }}–{{ $devices->lastItem() ?? 0 }} of {{ $devices->total() }}
            </small>
            {{ $devices->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@endsection