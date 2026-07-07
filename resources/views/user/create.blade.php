@extends('layouts.app')
@section('title', 'Tambah User')
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('user.index') }}">User</a></li><li class="breadcrumb-item active">Tambah</li>@endsection
@section('content')
<x-page-header title="Tambah User" />
<x-data-table>
    <form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6"><x-form-input label="Nama Lengkap" name="name" required /></div>
            <div class="col-md-6"><x-form-input label="Username" name="username" required /></div>
        </div>
        <div class="row">
            <div class="col-md-6"><x-form-input label="Email" name="email" type="email" required /></div>
            <div class="col-md-6">
                <x-form-select label="Role" name="role_id" required>
                    @foreach($roles as $r)<option value="{{ $r->id }}">{{ $r->nama }}</option>@endforeach
                </x-form-select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6"><x-form-input label="Password" name="password" type="password" required /></div>
            <div class="col-md-6"><x-form-input label="Konfirmasi Password" name="password_confirmation" type="password" required /></div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <x-form-select label="Status" name="status" required>
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </x-form-select>
            </div>
            <div class="col-md-6"><label class="form-label small fw-semibold">Foto</label><input type="file" name="foto" class="form-control"></div>
        </div>
        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-emerald"><i class="bi bi-save me-1"></i>Simpan</button>
            <a href="{{ route('user.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</x-data-table>
@endsection
