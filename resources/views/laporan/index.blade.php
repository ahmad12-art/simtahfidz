@extends('layouts.app')

@section('title', 'Laporan')

@section('breadcrumb')
    <li class="breadcrumb-item active">Laporan</li>
@endsection

@section('content')
<x-page-header title="Pusat Laporan" subtitle="Pilih jenis laporan, atur filter, lalu cetak PDF atau export Excel" />

<div class="row g-3">
    @foreach($jenisLaporan as $slug => $nama)
    <div class="col-md-6 col-lg-4">
        <div class="content-card p-3 h-100">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="stat-icon"><i class="bi bi-file-earmark-bar-graph"></i></div>
                <h6 class="fw-bold mb-0">{{ $nama }}</h6>
            </div>
            <form method="GET" action="{{ route('laporan.preview', $slug) }}" class="d-flex flex-column gap-2">
                @if(in_array($slug, ['rekap-setoran','rekap-murajaah','laporan-bulanan']))
                    <input type="date" name="tanggal_awal" class="form-control form-control-sm" placeholder="Tanggal awal">
                    <input type="date" name="tanggal_akhir" class="form-control form-control-sm" placeholder="Tanggal akhir">
                @endif
                @if(in_array($slug, ['progress-hafalan','rekap-setoran','laporan-santri','laporan-kelas','rekap-nilai']))
                    <select name="kelas_id" class="form-select form-select-sm">
                        <option value="">Semua Kelas</option>
                        @foreach($kelas as $k)<option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>@endforeach
                    </select>
                @endif
                @if(in_array($slug, ['rekap-nilai','laporan-tahunan']))
                    <select name="semester_id" class="form-select form-select-sm">
                        <option value="">Semua Semester</option>
                        @foreach($semester as $sm)<option value="{{ $sm->id }}">{{ $sm->tahunAjaran->nama }} - {{ $sm->nama }}</option>@endforeach
                    </select>
                @endif

                <div class="d-flex gap-2 mt-2">
                    <button type="submit" class="btn btn-outline-emerald btn-sm flex-fill"><i class="bi bi-eye me-1"></i>Preview</button>
                </div>
            </form>
            <div class="d-flex gap-2 mt-2">
                <a href="{{ route('laporan.pdf', $slug) }}" class="btn btn-emerald btn-sm flex-fill"><i class="bi bi-file-earmark-pdf me-1"></i>PDF</a>
                @if(in_array($slug, ['rekap-setoran','rekap-murajaah','rekap-nilai','laporan-santri']))
                <a href="{{ route('laporan.excel', $slug) }}" class="btn btn-gold btn-sm flex-fill"><i class="bi bi-file-earmark-excel me-1"></i>Excel</a>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
