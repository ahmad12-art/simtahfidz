@extends('layouts.app')
@section('title', 'Tambah Penilaian')
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('penilaian.index') }}">Penilaian</a></li><li class="breadcrumb-item active">Tambah</li>@endsection
@section('content')
<x-page-header title="Tambah Penilaian Semester" subtitle="Nilai Akhir = Kelancaran 35% + Tajwid 30% + Makhraj 20% + Adab 10% + Kehadiran 5%" />
<x-data-table>
    <form method="POST" action="{{ route('penilaian.store') }}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <x-form-select label="Santri" name="santri_id" required>
                    @foreach($santri as $s)<option value="{{ $s->id }}">{{ $s->nama }}</option>@endforeach
                </x-form-select>
            </div>
            <div class="col-md-6">
                <x-form-select label="Semester" name="semester_id" required>
                    @foreach($semester as $sm)<option value="{{ $sm->id }}">{{ $sm->tahunAjaran->nama }} - {{ $sm->nama }}</option>@endforeach
                </x-form-select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"><x-form-input label="Kelancaran" name="kelancaran" type="number" required /></div>
            <div class="col-md-4"><x-form-input label="Tajwid" name="tajwid" type="number" required /></div>
            <div class="col-md-4"><x-form-input label="Makhraj" name="makhraj" type="number" required /></div>
        </div>
        <div class="row">
            <div class="col-md-6"><x-form-input label="Adab" name="adab" type="number" required /></div>
            <div class="col-md-6"><x-form-input label="Kehadiran (%)" name="kehadiran" type="number" value="100" required /></div>
        </div>
        <x-form-input label="Catatan" name="catatan" />
        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-emerald"><i class="bi bi-save me-1"></i>Simpan</button>
            <a href="{{ route('penilaian.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</x-data-table>
@endsection
