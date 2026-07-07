@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')
    <x-flash-message />

    <form method="POST" action="{{ route('login.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label small fw-semibold">Username atau Email</label>
            <input type="text" name="username" value="{{ old('username') }}" autofocus
                   class="form-control @error('username') is-invalid @enderror" placeholder="Masukkan username">
            @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label small fw-semibold">Password</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label small" for="remember">Ingat saya</label>
            </div>
            <a href="{{ route('password.request') }}" class="small">Lupa password?</a>
        </div>

        <button type="submit" class="btn btn-emerald w-100">Masuk</button>
    </form>

    <p class="text-center small text-muted mt-4 mb-0">&copy; {{ date('Y') }} SIMTAHFIDZ — Sistem Informasi Manajemen Hafalan Al-Qur'an</p>
@endsection
