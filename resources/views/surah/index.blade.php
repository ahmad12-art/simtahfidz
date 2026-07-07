@extends('layouts.app')
@section('title', 'Data Surah')
@section('breadcrumb')<li class="breadcrumb-item active">Surah</li>@endsection
@section('content')
<x-page-header title="Data Surah" subtitle="Master data 114 surah Al-Qur'an">
    <x-slot:actions><a href="{{ route('surah.create') }}" class="btn btn-emerald btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah Surah</a></x-slot:actions>
</x-page-header>
<x-data-table>
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4"><input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari nama surah..."></div>
        <div class="col-md-3">
            <select name="kategori" class="form-select form-select-sm">
                <option value="">Semua Kategori</option>
                <option value="Makkiyah" @selected(request('kategori')==='Makkiyah')>Makkiyah</option>
                <option value="Madaniyah" @selected(request('kategori')==='Madaniyah')>Madaniyah</option>
            </select>
        </div>
        <div class="col-md-2"><button class="btn btn-outline-emerald btn-sm w-100"><i class="bi bi-search"></i> Cari</button></div>
    </form>
    @if($surah->isEmpty())
        <x-empty-state icon="bi-book" message="Belum ada data surah." />
    @else
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead><tr><th>No</th><th>Nama Surah</th><th>Jml Ayat</th><th>Juz</th><th>Kategori</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
            @foreach($surah as $s)
                <tr>
                    <td>{{ $s->nomor_surah }}</td>
                    <td class="fw-semibold">{{ $s->nama_surah }}</td>
                    <td>{{ $s->jumlah_ayat }}</td>
                    <td>{{ $s->juz ?? '-' }}</td>
                    <td><span class="badge bg-light text-dark">{{ $s->kategori ?? '-' }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('surah.edit', $s) }}" class="btn btn-sm btn-light"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('surah.destroy', $s) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus surah {{ $s->nama_surah }}?')">
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
        <p class="small text-muted mb-0">Menampilkan {{ $surah->firstItem() }}–{{ $surah->lastItem() }} dari {{ $surah->total() }} data</p>
        {{ $surah->links() }}
    </div>
    @endif
</x-data-table>
@endsection
