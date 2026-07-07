@extends('layouts.app')

@section('title', 'Edit Guru')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('guru.index') }}">Guru</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<x-page-header title="Edit Guru" :subtitle="$guru->nama" />

<x-data-table>
    <form method="POST" action="{{ route('guru.update', $guru) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="row">
            <div class="col-md-4 text-center mb-3">
                <img src="{{ $guru->foto_url }}" onerror="this.src='https://ui-avatars.com/api/?background=059669&color=fff&size=128&name={{ urlencode($guru->nama) }}'" class="rounded-circle mb-2" width="120" height="120">
                <input type="file" name="foto" class="form-control form-control-sm">
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6"><x-form-input label="NIP" name="nip" :value="$guru->nip" required /></div>
                    <div class="col-md-6"><x-form-input label="Nama Lengkap" name="nama" :value="$guru->nama" required /></div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form-select label="Jenis Kelamin" name="jenis_kelamin" required>
                            <option value="L" @selected($guru->jenis_kelamin==='L')>Laki-laki</option>
                            <option value="P" @selected($guru->jenis_kelamin==='P')>Perempuan</option>
                        </x-form-select>
                    </div>
                    <div class="col-md-6">
                        <x-form-select label="Status" name="status" required>
                            <option value="aktif" @selected($guru->status==='aktif')>Aktif</option>
                            <option value="nonaktif" @selected($guru->status==='nonaktif')>Nonaktif</option>
                        </x-form-select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6"><x-form-input label="Tempat Lahir" name="tempat_lahir" :value="$guru->tempat_lahir" /></div>
                    <div class="col-md-6"><x-form-input label="Tanggal Lahir" name="tanggal_lahir" type="date" :value="$guru->tanggal_lahir?->format('Y-m-d')" /></div>
                </div>
                <div class="row">
                    <div class="col-md-6"><x-form-input label="No. HP" name="no_hp" :value="$guru->no_hp" /></div>
                    <div class="col-md-6"><x-form-input label="Email" name="email" type="email" :value="$guru->email" /></div>
                </div>
                <x-form-input label="Alamat" name="alamat" :value="$guru->alamat" />
            </div>
        </div>

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-emerald"><i class="bi bi-save me-1"></i>Perbarui</button>
            <a href="{{ route('guru.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</x-data-table>
@endsection
