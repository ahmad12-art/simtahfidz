@extends('layouts.app')
@section('title', 'Tambah Kelas')
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('kelas.index') }}">Kelas</a></li><li class="breadcrumb-item active">Tambah</li>@endsection
@section('content')
<x-page-header title="Tambah Kelas" />
<x-data-table>
    <form method="POST" action="{{ route('kelas.store') }}">
        @csrf
        <div class="row">
            <div class="col-md-6"><x-form-input label="Nama Kelas" name="nama_kelas" required /></div>
            <div class="col-md-6"><x-form-input label="Tingkat" name="tingkat" /></div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <x-form-select label="Wali Kelas" name="wali_kelas_id">
                    @foreach($guru as $g)<option value="{{ $g->id }}">{{ $g->nama }}</option>@endforeach
                </x-form-select>
            </div>
            <div class="col-md-6">
                <x-form-select label="Tahun Ajaran" name="tahun_ajaran_id" required>
                    @foreach($tahunAjaran as $t)<option value="{{ $t->id }}">{{ $t->nama }}</option>@endforeach
                </x-form-select>
            </div>
        </div>
        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-emerald"><i class="bi bi-save me-1"></i>Simpan</button>
            <a href="{{ route('kelas.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</x-data-table>
@endsection
