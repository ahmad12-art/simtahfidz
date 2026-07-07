@extends('layouts.app')
@section('title', 'Murajaah')
@section('breadcrumb')<li class="breadcrumb-item active">Murajaah</li>@endsection
@section('content')
<x-page-header title="Murajaah" subtitle="Riwayat pengulangan hafalan santri">
    <x-slot:actions><a href="{{ route('murajaah.create') }}" class="btn btn-emerald btn-sm"><i class="bi bi-plus-lg me-1"></i>Input Murajaah</a></x-slot:actions>
</x-page-header>
<x-data-table>
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-3"><input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}" class="form-control form-control-sm"></div>
        <div class="col-md-3"><input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="form-control form-control-sm"></div>
        <div class="col-md-2"><button class="btn btn-outline-emerald btn-sm w-100"><i class="bi bi-search"></i> Filter</button></div>
    </form>
    @if($murajaah->isEmpty())
        <x-empty-state icon="bi-arrow-repeat" message="Belum ada data murajaah." />
    @else
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead><tr><th>Tanggal</th><th>Santri</th><th>Guru</th><th>Surah</th><th>Ayat</th><th>Nilai</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
            @foreach($murajaah as $m)
                <tr>
                    <td>{{ $m->tanggal->format('d-m-Y') }}</td>
                    <td class="fw-semibold">{{ $m->santri->nama }}</td>
                    <td>{{ $m->guru->nama }}</td>
                    <td>{{ $m->surah->nama_surah }}</td>
                    <td>{{ $m->ayat_awal }}-{{ $m->ayat_akhir }}</td>
                    <td><span class="fw-bold">{{ $m->nilai_akhir }}</span></td>
                    <td><span class="badge badge-status-{{ $m->status }}">{{ ucfirst(str_replace('_',' ',$m->status)) }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('murajaah.edit', $m) }}" class="btn btn-sm btn-light"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('murajaah.destroy', $m) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data murajaah ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-light text-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-between align-items-center mt-3">
        <p class="small text-muted mb-0">Menampilkan {{ $murajaah->firstItem() }}–{{ $murajaah->lastItem() }} dari {{ $murajaah->total() }} data</p>
        {{ $murajaah->links() }}
    </div>
    @endif
</x-data-table>
@endsection
