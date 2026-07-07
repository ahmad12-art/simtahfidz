@extends('layouts.app')
@section('title', $judul)
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('laporan.index') }}">Laporan</a></li><li class="breadcrumb-item active">{{ $judul }}</li>@endsection
@section('content')
<x-page-header :title="$judul" subtitle="Preview laporan">
    <x-slot:actions>
        <a href="{{ route('laporan.pdf', ['jenis' => 'rekap-murajaah', ...$filters]) }}" class="btn btn-emerald btn-sm"><i class="bi bi-file-earmark-pdf me-1"></i>PDF</a>
        <a href="{{ route('laporan.excel', ['jenis' => 'rekap-murajaah', ...$filters]) }}" class="btn btn-gold btn-sm"><i class="bi bi-file-earmark-excel me-1"></i>Excel</a>
    </x-slot:actions>
</x-page-header>
<x-data-table>
    @if($items->isEmpty())
        <x-empty-state message="Tidak ada data untuk filter yang dipilih." />
    @else
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead class="table-light"><tr><th>#</th><th>Tanggal</th><th>Santri</th><th>Guru</th><th>Surah</th><th>Ayat</th><th>Nilai</th></tr></thead>
            <tbody>
            @foreach($items as $i => $m)
                <tr>
                    <td>{{ $i+1 }}</td><td>{{ $m->tanggal->format('d-m-Y') }}</td><td>{{ $m->santri->nama }}</td>
                    <td>{{ $m->guru->nama }}</td><td>{{ $m->surah->nama_surah }}</td><td>{{ $m->ayat_awal }}-{{ $m->ayat_akhir }}</td><td>{{ $m->nilai_akhir }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
</x-data-table>
@endsection
