@extends('layouts.app')
@section('title', 'Dashboard — HRMS')

@section('content')
@php
    $badge = [
        'Present'    => 'bg-success-subtle text-success border border-success-subtle',
        'Late'       => 'bg-warning-subtle text-warning-emphasis border border-warning-subtle',
        'Absent'     => 'bg-danger-subtle text-danger border border-danger-subtle',
        'Leave'      => 'bg-info-subtle text-info-emphasis border border-info-subtle',
        'Weekly-off' => 'bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle',
    ];
@endphp

<div class="mb-4">
    <h1 class="h3 fw-bold mb-1">Live Presence Monitoring</h1>
    <p class="text-muted mb-0 small">Overview of member presence logs across all devices</p>
</div>

<div class="row g-3 mb-4">
    @foreach ([
         ['Devices Online',        $stats['on_leave'],        'bi-cpu-fill',       'hrms-stat-cyan'],
        ['Total Members', $stats['total_employees'], 'bi-people',         'hrms-stat-purple'],
        ['Members Present in Zone',   $stats['present_today'],   'bi-check2-circle',  'hrms-stat-green'],
        ['Members Out of zone',        $stats['on_leave'],        'bi-airplane',       'hrms-stat-cyan']
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

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
            <h2 class="h6 fw-semibold mb-0">
                <i class="bi bi-journal-text me-2 text-primary"></i> Member Presence Logs (Today)
            </h2>
            <form method="GET" action="{{ route('dashboard') }}" class="input-group" style="max-width:320px">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="text" name="q" value="{{ $search }}" class="form-control" placeholder="Search employee or ID">
                <button class="btn btn-outline-secondary" type="submit">Go</button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Member</th><th>Date</th>
                        <th>Effective</th><th>Gross</th><th>Last Detected Zone</th><th>Last Detected On</th><th>Status</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($logs as $log)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-2 fw-bold hrms-emp-avatar">
                                    {{ strtoupper(substr($log->employee_name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $log->employee_name }}</div>
                                    <div class="text-muted small">{{ $log->employee_code }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $log->log_date->format('D, d M Y') }}</td>
                        <td>{{ $log->effective_hours }}</td>
                        <td>{{ $log->gross_hours }}</td>
                        <td>Cubbicle 1</td>
                        <td>12:00:01 PM</td>
                        <td><span class="badge {{ $badge[$log->status] ?? 'bg-secondary-subtle text-secondary-emphasis' }}">{{ $log->status }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">No matching logs found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
            <small class="text-muted">
                Showing {{ $logs->firstItem() ?? 0 }}–{{ $logs->lastItem() ?? 0 }} of {{ $logs->total() }}
            </small>
            {{ $logs->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
