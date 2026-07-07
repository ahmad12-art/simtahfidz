@extends('layouts.app')
@section('title', $judul)
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('laporan.index') }}">Laporan</a></li><li class="breadcrumb-item active">{{ $judul }}</li>@endsection
@section('content')
<x-page-header :title="$judul" subtitle="Rekap setoran bulan berjalan">
    <x-slot:actions><a href="{{ route('laporan.pdf', ['jenis'=>'laporan-bulanan', ...$filters]) }}" class="btn btn-emerald btn-sm"><i class="bi bi-file-earmark-pdf me-1"></i>PDF</a></x-slot:actions>
</x-page-header>
<x-data-table>
    @if($items->isEmpty())
        <x-empty-state message="Tidak ada data pada bulan ini." />
    @else
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead class="table-light"><tr><th>#</th><th>Tanggal</th><th>Santri</th><th>Kelas</th><th>Guru</th><th>Nilai</th></tr></thead>
            <tbody>
            @foreach($items as $i => $s)
                <tr><td>{{ $i+1 }}</td><td>{{ $s->tanggal->format('d-m-Y') }}</td><td>{{ $s->santri->nama }}</td><td>{{ $s->santri->kelas->nama_kelas ?? '-' }}</td><td>{{ $s->guru->nama }}</td><td>{{ $s->nilai_akhir }}</td></tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
</x-data-table>
@endsection
