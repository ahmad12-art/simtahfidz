<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Masuk')  — SIMTAHFIDZ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="auth-body d-flex align-items-center justify-content-center">
    <div class="auth-card shadow-lg">
        <div class="auth-brand text-center mb-4">
            <div class="brand-icon-lg mx-auto mb-2"><i class="bi bi-book-half"></i></div>
            <h4 class="fw-bold mb-0">SIMTAHFIDZ</h4>
            <p class="text-muted small">Sistem Informasi Manajemen Hafalan Al-Qur'an</p>
        </div>
        @yield('content')
    </div>
</body>
</html>
