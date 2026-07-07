@extends('layouts.app')

@section('title', 'Tambah Guru')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('guru.index') }}">Guru</a></li>
    <li class="breadcrumb-item active">Tambah</li>
@endsection

@section('content')
<x-page-header title="Tambah Guru" subtitle="Lengkapi form berikut untuk menambahkan data guru baru" />

<x-data-table>
    <form method="POST" action="{{ route('guru.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-4 text-center mb-3">
                <img src="{{ asset('img/default-avatar.png') }}" onerror="this.src='https://ui-avatars.com/api/?background=059669&color=fff&size=128&name=Guru'" class="rounded-circle mb-2" width="120" height="120">
                <input type="file" name="foto" class="form-control form-control-sm">
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6"><x-form-input label="NIP" name="nip" required /></div>
                    <div class="col-md-6"><x-form-input label="Nama Lengkap" name="nama" required /></div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form-select label="Jenis Kelamin" name="jenis_kelamin" required>
                            <option value="L" @selected(old('jenis_kelamin')==='L')>Laki-laki</option>
                            <option value="P" @selected(old('jenis_kelamin')==='P')>Perempuan</option>
                        </x-form-select>
                    </div>
                    <div class="col-md-6">
                        <x-form-select label="Status" name="status" required>
                            <option value="aktif" selected>Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </x-form-select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6"><x-form-input label="Tempat Lahir" name="tempat_lahir" /></div>
                    <div class="col-md-6"><x-form-input label="Tanggal Lahir" name="tanggal_lahir" type="date" /></div>
                </div>
                <div class="row">
                    <div class="col-md-6"><x-form-input label="No. HP" name="no_hp" /></div>
                    <div class="col-md-6"><x-form-input label="Email" name="email" type="email" /></div>
                </div>
                <x-form-input label="Alamat" name="alamat" />
            </div>
        </div>

        <hr>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="buat_akun" value="1" id="buatAkun" onclick="document.getElementById('akunFields').classList.toggle('d-none')">
            <label class="form-check-label small fw-semibold" for="buatAkun">Buat akun login untuk guru ini</label>
        </div>
        <div id="akunFields" class="row d-none">
            <div class="col-md-6"><x-form-input label="Username" name="username" /></div>
            <div class="col-md-6"><x-form-input label="Password" name="password" type="password" /></div>
        </div>

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-emerald"><i class="bi bi-save me-1"></i>Simpan</button>
            <a href="{{ route('guru.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</x-data-table>
@endsection
