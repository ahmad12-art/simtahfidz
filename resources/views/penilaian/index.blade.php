@extends('layouts.app')
@section('title', 'Penilaian')
@section('breadcrumb')<li class="breadcrumb-item active">Penilaian</li>@endsection
@section('content')
<x-page-header title="Penilaian Semester" subtitle="Rekap nilai akhir santri per semester">
    <x-slot:actions><a href="{{ route('penilaian.create') }}" class="btn btn-emerald btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah Penilaian</a></x-slot:actions>
</x-page-header>
<x-data-table>
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <select name="semester_id" class="form-select form-select-sm">
                <option value="">Semua Semester</option>
                @foreach($semester as $sm)
                    <option value="{{ $sm->id }}" @selected(request('semester_id')==$sm->id)>{{ $sm->tahunAjaran->nama }} - {{ $sm->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="predikat" class="form-select form-select-sm">
                <option value="">Semua Predikat</option>
                @foreach(['A','B','C','D'] as $p)<option value="{{ $p }}" @selected(request('predikat')===$p)>{{ $p }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-2"><button class="btn btn-outline-emerald btn-sm w-100"><i class="bi bi-search"></i> Filter</button></div>
    </form>
    @if($penilaian->isEmpty())
        <x-empty-state icon="bi-clipboard-check" message="Belum ada data penilaian." />
    @else
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead><tr><th>Santri</th><th>Semester</th><th>Kelancaran</th><th>Tajwid</th><th>Makhraj</th><th>Adab</th><th>Kehadiran</th><th>Nilai Akhir</th><th>Predikat</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
            @foreach($penilaian as $p)
                <tr>
                    <td class="fw-semibold">{{ $p->santri->nama }}</td>
                    <td>{{ $p->semester->tahunAjaran->nama ?? '' }} - {{ $p->semester->nama }}</td>
                    <td>{{ $p->kelancaran }}</td>
                    <td>{{ $p->tajwid }}</td>
                    <td>{{ $p->makhraj }}</td>
                    <td>{{ $p->adab }}</td>
                    <td>{{ $p->kehadiran }}</td>
                    <td class="fw-bold">{{ $p->nilai_akhir }}</td>
                    <td><span class="badge badge-predikat-{{ $p->predikat }}">{{ $p->predikat }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('penilaian.edit', $p) }}" class="btn btn-sm btn-light"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('penilaian.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus penilaian ini?')">
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
        <p class="small text-muted mb-0">Menampilkan {{ $penilaian->firstItem() }}–{{ $penilaian->lastItem() }} dari {{ $penilaian->total() }} data</p>
        {{ $penilaian->links() }}
    </div>
    @endif
</x-data-table>
@endsection
