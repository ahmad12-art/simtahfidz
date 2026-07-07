@extends('layouts.auth')

@section('title', 'Lupa Password')

@section('content')
    <x-flash-message />
    <p class="text-muted small mb-3">Masukkan email Anda, kami akan mengirimkan tautan untuk membuat password baru.</p>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label small fw-semibold">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-emerald w-100">Kirim Tautan Reset</button>
    </form>
    <p class="text-center small mt-3"><a href="{{ route('login') }}">Kembali ke halaman login</a></p>
@endsection
