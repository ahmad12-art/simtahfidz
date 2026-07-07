@extends('layouts.app')

@section('title', 'Edit Santri')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('santri.index') }}">Santri</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<x-page-header title="Edit Santri" :subtitle="$santri->nama" />

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
        <strong><i class="bi bi-exclamation-triangle-fill me-1"></i>Terdapat kesalahan pada input:</strong>
        <ul class="mb-0 mt-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<x-data-table>
    <form method="POST" action="{{ route('santri.update', $santri) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="row">
            <div class="col-md-4 text-center mb-3">
                <img src="{{ $santri->foto_url }}" onerror="this.src='https://ui-avatars.com/api/?background=2563eb&color=fff&size=128&name={{ urlencode($santri->nama) }}'" class="rounded-circle mb-2" width="120" height="120">
                <input type="file" name="foto" class="form-control form-control-sm">
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6"><x-form-input label="NIS" name="nis" :value="$santri->nis" required /></div>
                    <div class="col-md-6"><x-form-input label="Nama Lengkap" name="nama" :value="$santri->nama" required /></div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form-select label="Jenis Kelamin" name="jenis_kelamin" required>
                            <option value="L" @selected($santri->jenis_kelamin==='L')>Laki-laki</option>
                            <option value="P" @selected($santri->jenis_kelamin==='P')>Perempuan</option>
                        </x-form-select>
                    </div>
                    <div class="col-md-6">
                        <x-form-select label="Kelas" name="kelas_id">
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" @selected($santri->kelas_id==$k->id)>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </x-form-select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6"><x-form-input label="Tempat Lahir" name="tempat_lahir" :value="$santri->tempat_lahir" /></div>
                    <div class="col-md-6"><x-form-input label="Tanggal Lahir" name="tanggal_lahir" type="date" :value="$santri->tanggal_lahir?->format('Y-m-d')" /></div>
                </div>
                <div class="row">
                    <div class="col-md-6"><x-form-input label="Nama Wali" name="nama_wali" :value="$santri->nama_wali" /></div>
                    <div class="col-md-6"><x-form-input label="No. HP Wali" name="no_hp_wali" :value="$santri->no_hp_wali" /></div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-form-select label="Status" name="status" required>
                            @foreach(['aktif','lulus','pindah','nonaktif'] as $st)
                                <option value="{{ $st }}" @selected($santri->status===$st)>{{ ucfirst($st) }}</option>
                            @endforeach
                        </x-form-select>
                    </div>
                    <div class="col-md-6"><x-form-input label="Alamat" name="alamat" :value="$santri->alamat" /></div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-emerald"><i class="bi bi-save me-1"></i>Perbarui</button>
            <a href="{{ route('santri.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</x-data-table>
@endsection
