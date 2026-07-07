@extends('layouts.app')
@section('title', 'Profil Saya')
@section('breadcrumb')<li class="breadcrumb-item active">Profil</li>@endsection
@section('content')
<x-page-header title="Profil Saya" subtitle="Kelola informasi akun dan password Anda" />
<div class="row">
    <div class="col-md-8">
        <x-data-table>
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="text-center mb-3">
                    <img src="{{ $user->foto ? asset('storage/'.$user->foto) : 'https://ui-avatars.com/api/?background=059669&color=fff&size=128&name='.urlencode($user->name) }}" class="rounded-circle mb-2" object-fit="cover" width="100" height="100">
                    <input type="file" name="foto" class="form-control form-control-sm w-50 mx-auto">
                </div>
                <x-form-input label="Nama Lengkap" name="name" :value="$user->name" required />
                <x-form-input label="Email" name="email" type="email" :value="$user->email" required />
                <hr>
                <p class="small fw-semibold text-muted">Ubah Password (opsional)</p>
                <x-form-input label="Password Baru" name="password" type="password" />
                <x-form-input label="Konfirmasi Password" name="password_confirmation" type="password" />
                <button type="submit" class="btn btn-emerald"><i class="bi bi-save me-1"></i>Simpan Perubahan</button>
            </form>
        </x-data-table>
    </div>
</div>
@endsection
