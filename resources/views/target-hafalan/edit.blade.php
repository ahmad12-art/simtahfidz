@extends('layouts.app')
@section('title', 'Edit Target Hafalan')
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('target-hafalan.index') }}">Target Hafalan</a></li><li class="breadcrumb-item active">Edit</li>@endsection
@section('content')
<x-page-header title="Edit Target Hafalan" />
<x-data-table>
    <form method="POST" action="{{ route('target-hafalan.update', $targetHafalan) }}">
        @csrf @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <x-form-select label="Santri" name="santri_id" required>
                    @foreach($santri as $s)<option value="{{ $s->id }}" @selected($targetHafalan->santri_id==$s->id)>{{ $s->nama }}</option>@endforeach
                </x-form-select>
            </div>
            <div class="col-md-6">
                <x-form-select label="Guru Pembimbing" name="guru_id" required>
                    @foreach($guru as $g)<option value="{{ $g->id }}" @selected($targetHafalan->guru_id==$g->id)>{{ $g->nama }}</option>@endforeach
                </x-form-select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <x-form-select label="Surah" name="surah_id" required>
                    @foreach($surah as $s)<option value="{{ $s->id }}" @selected($targetHafalan->surah_id==$s->id)>{{ $s->nomor_surah }}. {{ $s->nama_surah }}</option>@endforeach
                </x-form-select>
            </div>
            <div class="col-md-4"><x-form-input label="Ayat Awal" name="ayat_awal" type="number" :value="$targetHafalan->ayat_awal" required /></div>
            <div class="col-md-4"><x-form-input label="Ayat Akhir" name="ayat_akhir" type="number" :value="$targetHafalan->ayat_akhir" required /></div>
        </div>
        <div class="row">
            <div class="col-md-6"><x-form-input label="Tanggal Mulai" name="tanggal_mulai" type="date" :value="$targetHafalan->tanggal_mulai->format('Y-m-d')" required /></div>
            <div class="col-md-6"><x-form-input label="Deadline" name="deadline" type="date" :value="$targetHafalan->deadline?->format('Y-m-d')" /></div>
        </div>
        <x-form-input label="Catatan" name="catatan" :value="$targetHafalan->catatan" />
        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-emerald"><i class="bi bi-save me-1"></i>Perbarui</button>
            <a href="{{ route('target-hafalan.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</x-data-table>
@endsection
