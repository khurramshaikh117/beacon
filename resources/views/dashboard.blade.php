@extends('layouts.app')
@section('title', 'Dashboard — ZAVI')

@section('content')

<div class="mb-4">
    <h1 class="h3 fw-bold mb-1">Live Presence Monitoring</h1>
    <p class="text-muted mb-0 small">Overview of member presence logs across all devices. All times shown in IST (India Standard Time).</p>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    @foreach ([
        ['Devices Online',          $stats['devices_online'], 'bi-cpu-fill',      'hrms-stat-cyan'],
        ['Total Members',           $stats['total_members'],  'bi-people',        'hrms-stat-purple'],
        ['Members Present in Zone', $stats['members_in'],     'bi-check2-circle', 'hrms-stat-green'],
        ['Members Out of Zone',     $stats['members_out'],    'bi-airplane',      'hrms-stat-cyan'],
    ] as $s)
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded d-flex align-items-center justify-content-center me-3 hrms-stat-icon {{ $s[3] }}">
                    <i class="bi {{ $s[2] }} fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">{{ $s[0] }}</div>
                    <div class="h4 fw-bold mb-0">{{ $s[1] }}</div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Member Table --}}
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-2">
            <h2 class="h6 fw-semibold mb-0">
                <i class="bi bi-journal-text me-2 text-primary"></i>
                Member Presence Logs (Today)
            </h2>
            <form method="GET" action="{{ route('dashboard') }}" class="input-group" style="max-width:320px">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="text" name="q" value="{{ $search }}" class="form-control" placeholder="Search member or ID">
                <button class="btn btn-outline-secondary" type="submit">Go</button>
            </form>
        </div>
        <p class="text-muted small mb-3">
            <strong>Effective</strong> = time physically in zone (sum of IN→OUT periods).
            <strong>Gross</strong> = first IN today until last activity (includes gaps).
        </p>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Member</th>
                        <th>Date</th>
                        <th>
                            Effective
                            <i class="bi bi-info-circle text-muted ms-1"
                               data-bs-toggle="tooltip"
                               data-bs-placement="top"
                               title="Total time in zone today, counted only between IN and OUT events. If still present, includes time until now."></i>
                        </th>
                        <th>
                            Gross
                            <i class="bi bi-info-circle text-muted ms-1"
                               data-bs-toggle="tooltip"
                               data-bs-placement="top"
                               title="Time from your first IN today to your last detected activity, including any gaps when you were out of zone."></i>
                        </th>
                        <th>
                            Last Detected Location
                            <i class="bi bi-info-circle text-muted ms-1"
                               data-bs-toggle="tooltip"
                               data-bs-placement="top"
                               title="Device name (e.g. Bedroom) where the member was last detected by an ESP32 scanner."></i>
                        </th>
                        <th>Last Detected On (IST)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($members as $member)
                    @php
                        $presence = $member->latestPresence;
                        $hours    = $effectiveHours[$member->user_uuid] ?? ['effective' => '0h 0m', 'gross' => '0h 0m'];
                        $isIn     = $presence?->isIn() ?? false;
                        $location = $presence?->device?->label ?? $presence?->zone;
                    @endphp
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-2 fw-bold hrms-emp-avatar">
                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $member->name }}</div>
                                    <div class="text-muted small">{{ $member->user_uuid }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($presence)
                                {{ $presence->created_at->format('D, d M Y') }}
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>{{ $hours['effective'] }}</td>
                        <td>{{ $hours['gross'] }}</td>
                        <td>{{ $location ?? '—' }}</td>
                        <td>
                            @if($presence)
                                {{ $presence->created_at->format('h:i:s A') }}
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if($isIn)
                                <span class="badge bg-success-subtle text-success border border-success-subtle">Present</span>
                            @elseif($presence)
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Left</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">No Data</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            No members found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
            <small class="text-muted">
                Showing {{ $members->firstItem() ?? 0 }}–{{ $members->lastItem() ?? 0 }} of {{ $members->total() }}
            </small>
            {{ $members->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (el) {
        new bootstrap.Tooltip(el);
    });
</script>
@endpush
