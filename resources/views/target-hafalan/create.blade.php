@extends('layouts.app')
@section('title', 'Tambah Target Hafalan')
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('target-hafalan.index') }}">Target Hafalan</a></li><li class="breadcrumb-item active">Tambah</li>@endsection
@section('content')
<x-page-header title="Tambah Target Hafalan" />
<x-data-table>
    <form method="POST" action="{{ route('target-hafalan.store') }}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <x-form-select label="Santri" name="santri_id" required>
                    @foreach($santri as $s)<option value="{{ $s->id }}">{{ $s->nama }}</option>@endforeach
                </x-form-select>
            </div>
            <div class="col-md-6">
                <x-form-select label="Guru Pembimbing" name="guru_id" required>
                    @foreach($guru as $g)<option value="{{ $g->id }}">{{ $g->nama }}</option>@endforeach
                </x-form-select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <x-form-select label="Surah" name="surah_id" required>
                    @foreach($surah as $s)<option value="{{ $s->id }}">{{ $s->nomor_surah }}. {{ $s->nama_surah }}</option>@endforeach
                </x-form-select>
            </div>
            <div class="col-md-4"><x-form-input label="Ayat Awal" name="ayat_awal" type="number" required /></div>
            <div class="col-md-4"><x-form-input label="Ayat Akhir" name="ayat_akhir" type="number" required /></div>
        </div>
        <div class="row">
            <div class="col-md-6"><x-form-input label="Tanggal Mulai" name="tanggal_mulai" type="date" required /></div>
            <div class="col-md-6"><x-form-input label="Deadline" name="deadline" type="date" /></div>
        </div>
        <x-form-input label="Catatan" name="catatan" />
        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-emerald"><i class="bi bi-save me-1"></i>Simpan</button>
            <a href="{{ route('target-hafalan.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</x-data-table>
@endsection
