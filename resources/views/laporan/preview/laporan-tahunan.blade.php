@extends('layouts.app')
@section('title', $judul)
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('laporan.index') }}">Laporan</a></li><li class="breadcrumb-item active">{{ $judul }}</li>@endsection
@section('content')
<x-page-header :title="$judul" subtitle="Rekap nilai tahunan (gabungan semester)">
    <x-slot:actions><a href="{{ route('laporan.pdf', ['jenis'=>'laporan-tahunan', ...$filters]) }}" class="btn btn-emerald btn-sm"><i class="bi bi-file-earmark-pdf me-1"></i>PDF</a></x-slot:actions>
</x-page-header>
<x-data-table>
    @if($items->isEmpty())
        <x-empty-state message="Tidak ada data untuk filter yang dipilih." />
    @else
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead class="table-light"><tr><th>#</th><th>Santri</th><th>Semester</th><th>Nilai Akhir</th><th>Predikat</th></tr></thead>
            <tbody>
            @foreach($items as $i => $p)
                <tr><td>{{ $i+1 }}</td><td>{{ $p->santri->nama }}</td><td>{{ $p->semester->nama }}</td><td>{{ $p->nilai_akhir }}</td><td>{{ $p->predikat }}</td></tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
</x-data-table>
@endsection
