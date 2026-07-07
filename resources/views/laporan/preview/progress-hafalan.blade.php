@extends('layouts.app')

@section('title', $judul)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('laporan.index') }}">Laporan</a></li>
    <li class="breadcrumb-item active">{{ $judul }}</li>
@endsection

@section('content')
<x-page-header :title="$judul" subtitle="Preview laporan — gunakan tombol di kanan untuk mencetak">
    <x-slot:actions>
        <a href="{{ route('laporan.pdf', ['jenis' => 'progress-hafalan', ...$filters]) }}" class="btn btn-emerald btn-sm"><i class="bi bi-file-earmark-pdf me-1"></i>Cetak PDF</a>
    </x-slot:actions>
</x-page-header>

<x-data-table>
    @if($items->isEmpty())
        <x-empty-state message="Tidak ada data untuk filter yang dipilih." />
    @else
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead class="table-light">
                <tr><th>#</th><th>Santri</th><th>Kelas</th><th>Guru</th><th>Surah</th><th>Ayat</th><th>Progress</th><th>Status</th></tr>
            </thead>
            <tbody>
            @foreach($items as $i => $t)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $t->santri->nama }}</td>
                    <td>{{ $t->santri->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $t->guru->nama }}</td>
                    <td>{{ $t->surah->nama_surah }}</td>
                    <td>{{ $t->ayat_awal }}-{{ $t->ayat_akhir }}</td>
                    <td>{{ $t->persentase_progress }}%</td>
                    <td>{{ ucfirst($t->status) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
</x-data-table>
@endsection
