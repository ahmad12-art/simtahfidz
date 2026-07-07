@extends('layouts.app')
@section('title', $judul)
@section('breadcrumb')<li class="breadcrumb-item"><a href="{{ route('laporan.index') }}">Laporan</a></li><li class="breadcrumb-item active">{{ $judul }}</li>@endsection
@section('content')
<x-page-header :title="$judul" subtitle="Preview laporan">
    <x-slot:actions><a href="{{ route('laporan.pdf', 'laporan-guru') }}" class="btn btn-emerald btn-sm"><i class="bi bi-file-earmark-pdf me-1"></i>PDF</a></x-slot:actions>
</x-page-header>
<x-data-table>
    @if($items->isEmpty())
        <x-empty-state message="Belum ada data guru." />
    @else
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead class="table-light"><tr><th>#</th><th>Nama</th><th>NIP</th><th>Total Setoran</th><th>Total Murajaah</th><th>Total Target</th></tr></thead>
            <tbody>
            @foreach($items as $i => $g)
                <tr><td>{{ $i+1 }}</td><td>{{ $g->nama }}</td><td>{{ $g->nip }}</td><td>{{ $g->setoran_count }}</td><td>{{ $g->murajaah_count }}</td><td>{{ $g->target_hafalan_count }}</td></tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @endif
</x-data-table>
@endsection
