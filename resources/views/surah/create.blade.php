@extends('layouts.app')
@section('title', 'Tambah Surah')
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('surah.index') }}">Surah</a></li><li class="breadcrumb-item active">Tambah</li>@endsection
@section('content')
<x-page-header title="Tambah Surah" />
<x-data-table>
    <form method="POST" action="{{ route('surah.store') }}">
        @csrf
        <div class="row">
            <div class="col-md-4"><x-form-input label="Nomor Surah" name="nomor_surah" type="number" required /></div>
            <div class="col-md-8"><x-form-input label="Nama Surah" name="nama_surah" required /></div>
        </div>
        <div class="row">
            <div class="col-md-4"><x-form-input label="Jumlah Ayat" name="jumlah_ayat" type="number" required /></div>
            <div class="col-md-4"><x-form-input label="Juz" name="juz" type="number" /></div>
            <div class="col-md-4">
                <x-form-select label="Kategori" name="kategori">
                    <option value="Makkiyah">Makkiyah</option>
                    <option value="Madaniyah">Madaniyah</option>
                </x-form-select>
            </div>
        </div>
        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-emerald"><i class="bi bi-save me-1"></i>Simpan</button>
            <a href="{{ route('surah.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</x-data-table>
@endsection
