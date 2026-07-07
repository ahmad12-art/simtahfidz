@extends('layouts.app')

@section('title', 'Detail Guru')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('guru.index') }}">Guru</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="row g-3">
    <div class="col-md-4">
        <div class="content-card text-center p-4">
            <img src="{{ $guru->foto_url }}" onerror="this.src='https://ui-avatars.com/api/?background=059669&color=fff&size=128&name={{ urlencode($guru->nama) }}'" class="rounded-circle mb-3" width="120" height="120">
            <h5 class="fw-bold mb-0">{{ $guru->nama }}</h5>
            <p class="text-muted small">{{ $guru->nip }}</p>
            <span class="badge badge-status-{{ $guru->status }}">{{ ucfirst($guru->status) }}</span>
            <hr>
            <ul class="list-unstyled text-start small">
                <li class="mb-2"><i class="bi bi-telephone me-2 text-muted"></i>{{ $guru->no_hp ?? '-' }}</li>
                <li class="mb-2"><i class="bi bi-envelope me-2 text-muted"></i>{{ $guru->email ?? '-' }}</li>
                <li class="mb-2"><i class="bi bi-geo-alt me-2 text-muted"></i>{{ $guru->alamat ?? '-' }}</li>
            </ul>
            <a href="{{ route('guru.edit', $guru) }}" class="btn btn-outline-emerald btn-sm w-100"><i class="bi bi-pencil me-1"></i>Edit Data</a>
        </div>
    </div>
    <div class="col-md-8">
        <x-data-table title="Kelas yang Diampu (Wali Kelas)">
            @forelse($guru->kelasWali as $k)
                <span class="badge bg-light text-dark me-1 mb-1">{{ $k->nama_kelas }}</span>
            @empty
                <p class="text-muted small mb-0">Belum menjadi wali kelas.</p>
            @endforelse
        </x-data-table>

        <div class="mt-3">
            <x-data-table title="10 Setoran Terakhir yang Dinilai">
                @if($guru->setoran->isEmpty())
                    <x-empty-state message="Belum ada data setoran." />
                @else
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead><tr><th>Tanggal</th><th>Nilai Akhir</th><th>Status</th></tr></thead>
                        <tbody>
                        @foreach($guru->setoran as $s)
                            <tr>
                                <td>{{ $s->tanggal->format('d-m-Y') }}</td>
                                <td>{{ $s->nilai_akhir }}</td>
                                <td><span class="badge badge-status-{{ $s->status }}">{{ $s->status }}</span></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </x-data-table>
        </div>
    </div>
</div>
@endsection
