@extends('layouts.app')

@section('title', 'Input Setoran Hafalan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('setoran.index') }}">Setoran Hafalan</a></li>
    <li class="breadcrumb-item active">Input</li>
@endsection

@section('content')
<x-page-header title="Input Setoran Hafalan" subtitle="Nilai akhir dihitung otomatis: Kelancaran 40%, Tajwid 30%, Makhraj 20%, Adab 10%" />

<x-data-table>
    <form method="POST" action="{{ route('setoran.store') }}">
        @csrf
        <div class="row">
            <div class="col-md-6"><x-form-input label="Tanggal" name="tanggal" type="date" :value="date('Y-m-d')" required /></div>
            <div class="col-md-6">
                <x-form-select label="Target Hafalan (opsional)" name="target_hafalan_id">
                    @foreach($target as $t)
                        <option value="{{ $t->id }}">{{ $t->santri->nama }} — {{ $t->surah->nama_surah ?? '' }}</option>
                    @endforeach
                </x-form-select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <x-form-select label="Santri" name="santri_id" required>
                    @foreach($santri as $s)<option value="{{ $s->id }}">{{ $s->nama }}</option>@endforeach
                </x-form-select>
            </div>
            <div class="col-md-4">
                <x-form-select label="Guru Penilai" name="guru_id" required>
                    @foreach($guru as $g)<option value="{{ $g->id }}" @selected(auth()->user()->guru?->id == $g->id)>{{ $g->nama }}</option>@endforeach
                </x-form-select>
            </div>
            <div class="col-md-4">
                <x-form-select label="Surah" name="surah_id" required>
                    @foreach($surah as $s)<option value="{{ $s->id }}">{{ $s->nomor_surah }}. {{ $s->nama_surah }}</option>@endforeach
                </x-form-select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6"><x-form-input label="Ayat Awal" name="ayat_awal" type="number" required /></div>
            <div class="col-md-6"><x-form-input label="Ayat Akhir" name="ayat_akhir" type="number" required /></div>
        </div>

        <hr>
        <h6 class="fw-bold mb-3">Penilaian</h6>
        <div class="row">
            <div class="col-md-3"><x-form-input label="Kelancaran (40%)" name="nilai_kelancaran" type="number" data-nilai-component required /></div>
            <div class="col-md-3"><x-form-input label="Tajwid (30%)" name="nilai_tajwid" type="number" data-nilai-component required /></div>
            <div class="col-md-3"><x-form-input label="Makhraj (20%)" name="nilai_makhraj" type="number" data-nilai-component required /></div>
            <div class="col-md-3"><x-form-input label="Adab (10%)" name="nilai_adab" type="number" data-nilai-component required /></div>
        </div>

        <div class="alert alert-light border d-flex align-items-center justify-content-between">
            <div>
                <span class="text-muted small">Perkiraan Nilai Akhir</span>
                <h4 class="mb-0" id="nilai-akhir-preview">0.00</h4>
            </div>
            <div class="text-end">
                <span class="text-muted small">Predikat</span>
                <h4 class="mb-0" id="predikat-preview">D</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <x-form-select label="Status" name="status" required>
                    <option value="lancar">Lancar</option>
                    <option value="mengulang">Mengulang</option>
                    <option value="belum_lancar">Belum Lancar</option>
                </x-form-select>
            </div>
        </div>
        <x-form-input label="Catatan" name="catatan" />

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-emerald"><i class="bi bi-save me-1"></i>Simpan Setoran</button>
            <a href="{{ route('setoran.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</x-data-table>
@endsection
