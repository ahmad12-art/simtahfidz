@extends('layouts.app')
@section('title', 'Pengaturan')
@section('breadcrumb')<li class="breadcrumb-item active">Pengaturan</li>@endsection
@section('content')
<x-page-header title="Pengaturan Sistem" subtitle="Atur tahun ajaran, semester aktif, dan backup database" />

<div class="row g-3">
    <div class="col-md-7">
        <x-data-table title="Tahun Ajaran & Semester Aktif">
            <form method="POST" action="{{ route('pengaturan.update') }}">
                @csrf @method('PUT')
                <x-form-select label="Tahun Ajaran Aktif" name="tahun_ajaran_aktif" required>
                    @foreach($tahunAjaran as $t)<option value="{{ $t->id }}" @selected($t->aktif)>{{ $t->nama }}</option>@endforeach
                </x-form-select>
                <x-form-select label="Semester Aktif" name="semester_aktif" required>
                    @foreach($semester as $s)<option value="{{ $s->id }}" @selected($s->aktif)>{{ $s->tahunAjaran->nama }} - {{ $s->nama }}</option>@endforeach
                </x-form-select>
                <button type="submit" class="btn btn-emerald"><i class="bi bi-save me-1"></i>Simpan Pengaturan</button>
            </form>
        </x-data-table>
    </div>
    <div class="col-md-5">
        <x-data-table title="Backup Database">
            <p class="text-muted small">Buat cadangan database sistem secara manual. Disarankan dilakukan secara berkala.</p>
            <form method="POST" action="{{ route('pengaturan.backup') }}" onsubmit="return confirm('Jalankan backup database sekarang?')">
                @csrf
                <button type="submit" class="btn btn-outline-emerald"><i class="bi bi-cloud-download me-1"></i>Backup Sekarang</button>
            </form>
        </x-data-table>
    </div>
</div>
@endsection
