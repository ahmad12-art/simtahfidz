@extends('layouts.app')
@section('title', $judul)
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('laporan.index') }}">Laporan</a></li><li class="breadcrumb-item active">{{ $judul }}</li>@endsection
@section('content')
<x-page-header :title="$judul" subtitle="Preview laporan">
    <x-slot:actions><a href="{{ route('laporan.pdf', 'laporan-kelas') }}" class="btn btn-emerald btn-sm"><i class="bi bi-file-earmark-pdf me-1"></i>PDF</a></x-slot:actions>
</x-page-header>
<x-data-table>
    @if($items->isEmpty())
        <x-empty-state message="Belum ada data kelas." />
    @else
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead class="table-light"><tr><th>#</th><th>Kelas</th><th>Wali Kelas</th><th>Jumlah Santri</th></tr></thead>
            <tbody>
            @foreach($items as $i => $k)
                <tr><td>{{ $i+1 }}</td><td>{{ $k->nama_kelas }}</td><td>{{ $k->waliKelas->nama ?? '-' }}</td><td>{{ $k->santri_count }}</td></tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
</x-data-table>
@endsection
