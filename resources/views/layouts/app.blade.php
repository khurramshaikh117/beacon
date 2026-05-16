<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'HRMS')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>
<body style="background:#f5f6fa">
<div class="d-flex min-vh-100">
    <aside class="hrms-sidebar d-flex flex-column text-white p-3">
        <div class="d-flex align-items-center mb-4">
            <i class="bi bi-phone-vibrate-fill fs-4 me-2"></i>
            <h5 class="mb-0 fw-bold">ZAVI</h5>
        </div>
        <nav class="nav flex-column gap-1 flex-grow-1">
            <a href="{{ route('dashboard') }}"
               class="btn text-start text-white d-flex align-items-center {{ request()->routeIs('dashboard') ? 'active-link' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
            <a href="{{ route('devices.index') }}"
                class="btn text-start text-white d-flex align-items-center {{ request()->routeIs('devices.*') ? 'active-link' : '' }}">
                    <i class="bi bi-hdd-network me-2"></i> Manage Devices
            </a>
        </nav>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-light text-danger fw-semibold w-100 d-flex align-items-center justify-content-center mt-3">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </button>
        </form>
    </aside>

    <main class="flex-grow-1 d-flex flex-column" style="min-width:0">
        <header class="hrms-topbar d-flex align-items-center justify-content-between px-4 py-3 text-white">
            <h6 class="mb-0 fw-semibold">Real-Time Presence Dashboard | ZAVI Admin Panel</h6>
            <div class="d-flex align-items-center gap-3">
                <!-- <i class="bi bi-bell fs-5"></i>
                <i class="bi bi-gear fs-5"></i> -->
                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold hrms-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
            </div>
        </header>

        <div class="p-4">
            @if (session('status'))
                <div class="alert alert-success py-2">{{ session('status') }}</div>
            @endif
            @yield('content')
        </div>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>
