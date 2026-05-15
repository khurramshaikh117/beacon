<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRMS — Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>
<body class="hrms-login-bg min-vh-100 d-flex align-items-center justify-content-center p-3">
    <div class="card shadow-lg border-0" style="max-width:420px;width:100%">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 hrms-logo-circle">
                    <!-- <i class="bi bi-people-fill text-white fs-3"></i>
                      -->
                    <i class="bi bi-phone-vibrate-fill text-white fs-3"></i>
                </div>
                <h3 class="fw-bold mb-1">Login</h3>
                <!-- <p class="text-muted small mb-0">Smart Attendance & HR Management System</p> -->
            </div>

            <form method="POST" action="{{ route('login.attempt') }}" novalidate>
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input id="email" name="email" type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required autofocus>
                    </div>
                    @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input id="password" name="password" type="password" class="form-control" required>
                    </div>
                </div>

                <!-- <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                    <label class="form-check-label small" for="remember">Remember me</label>
                </div> -->

                <button type="submit" class="btn w-100 text-white fw-semibold hrms-btn-primary">Sign In</button>

                <div class="text-center mt-3">
                    <small class="text-muted">Powered By : <strong>ZAVI</strong> | <strong>Smart HRMS</strong></small>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
