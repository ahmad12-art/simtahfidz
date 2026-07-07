@extends('layouts.app')
@section('title', 'Edit Penilaian')
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('penilaian.index') }}">Penilaian</a></li><li class="breadcrumb-item active">Edit</li>@endsection
@section('content')
<x-page-header title="Edit Penilaian Semester" />
<x-data-table>
    <form method="POST" action="{{ route('penilaian.update', $penilaian) }}">
        @csrf @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <x-form-select label="Santri" name="santri_id" required>
                    @foreach($santri as $s)<option value="{{ $s->id }}" @selected($penilaian->santri_id==$s->id)>{{ $s->nama }}</option>@endforeach
                </x-form-select>
            </div>
            <div class="col-md-6">
                <x-form-select label="Semester" name="semester_id" required>
                    @foreach($semester as $sm)<option value="{{ $sm->id }}" @selected($penilaian->semester_id==$sm->id)>{{ $sm->tahunAjaran->nama }} - {{ $sm->nama }}</option>@endforeach
                </x-form-select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"><x-form-input label="Kelancaran" name="kelancaran" type="number" :value="$penilaian->kelancaran" required /></div>
            <div class="col-md-4"><x-form-input label="Tajwid" name="tajwid" type="number" :value="$penilaian->tajwid" required /></div>
            <div class="col-md-4"><x-form-input label="Makhraj" name="makhraj" type="number" :value="$penilaian->makhraj" required /></div>
        </div>
        <div class="row">
            <div class="col-md-6"><x-form-input label="Adab" name="adab" type="number" :value="$penilaian->adab" required /></div>
            <div class="col-md-6"><x-form-input label="Kehadiran (%)" name="kehadiran" type="number" :value="$penilaian->kehadiran" required /></div>
        </div>
        <x-form-input label="Catatan" name="catatan" :value="$penilaian->catatan" />
        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-emerald"><i class="bi bi-save me-1"></i>Perbarui</button>
            <a href="{{ route('penilaian.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</x-data-table>
@endsection
