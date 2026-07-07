@extends('layouts.app')
@section('title', 'Data Kelas')
@section('breadcrumb')<li class="breadcrumb-item active">Kelas</li>@endsection
@section('content')
<x-page-header title="Data Kelas" subtitle="Kelola data kelas dan wali kelas">
    <x-slot:actions><a href="{{ route('kelas.create') }}" class="btn btn-emerald btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah Kelas</a></x-slot:actions>
</x-page-header>
<x-data-table>
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4"><input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Cari nama kelas..."></div>
        <div class="col-md-2"><button class="btn btn-outline-emerald btn-sm w-100"><i class="bi bi-search"></i> Cari</button></div>
    </form>
    @if($kelas->isEmpty())
        <x-empty-state icon="bi-door-open" message="Belum ada data kelas." />
    @else
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead><tr><th>#</th><th>Nama Kelas</th><th>Tingkat</th><th>Wali Kelas</th><th>Tahun Ajaran</th><th>Jml Santri</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
            @foreach($kelas as $k)
                <tr>
                    <td>{{ $loop->iteration + ($kelas->currentPage()-1)*$kelas->perPage() }}</td>
                    <td class="fw-semibold">{{ $k->nama_kelas }}</td>
                    <td>{{ $k->tingkat ?? '-' }}</td>
                    <td>{{ $k->waliKelas->nama ?? '-' }}</td>
                    <td>{{ $k->tahunAjaran->nama ?? '-' }}</td>
                    <td><span class="badge bg-light text-dark">{{ $k->santri_count }} santri</span></td>
                    <td class="text-end">
                        <a href="{{ route('kelas.edit', $k) }}" class="btn btn-sm btn-light"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('kelas.destroy', $k) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kelas {{ $k->nama_kelas }}?')">
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
        <p class="small text-muted mb-0">Menampilkan {{ $kelas->firstItem() }}–{{ $kelas->lastItem() }} dari {{ $kelas->total() }} data</p>
        {{ $kelas->links() }}
    </div>
    @endif
</x-data-table>
@endsection
