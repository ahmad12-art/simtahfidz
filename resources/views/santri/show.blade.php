@extends('layouts.app')

@section('title', 'Detail Santri')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('santri.index') }}">Santri</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="row g-3">
    <div class="col-md-4">
        <div class="content-card text-center p-4">
            <img src="{{ $santri->foto_url }}" onerror="this.src='https://ui-avatars.com/api/?background=2563eb&color=fff&size=128&name={{ urlencode($santri->nama) }}'" class="rounded-circle mb-3" width="120" height="120">
            <h5 class="fw-bold mb-0">{{ $santri->nama }}</h5>
            <p class="text-muted small">{{ $santri->nis }} — {{ $santri->kelas->nama_kelas ?? '-' }}</p>
            <span class="badge badge-status-{{ $santri->status }}">{{ ucfirst($santri->status) }}</span>
            <hr>
            <div class="bg-light rounded p-2 mb-2">
                <i class="bi bi-qr-code fs-1"></i>
                <p class="small text-muted mb-0">{{ $santri->qr_code }}</p>
            </div>
            <ul class="list-unstyled text-start small">
                <li class="mb-2"><i class="bi bi-person me-2 text-muted"></i>Wali: {{ $santri->nama_wali ?? '-' }}</li>
                <li class="mb-2"><i class="bi bi-telephone me-2 text-muted"></i>{{ $santri->no_hp_wali ?? '-' }}</li>
                <li class="mb-2"><i class="bi bi-geo-alt me-2 text-muted"></i>{{ $santri->alamat ?? '-' }}</li>
            </ul>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('santri.edit', $santri) }}" class="btn btn-outline-emerald btn-sm w-100"><i class="bi bi-pencil me-1"></i>Edit Data</a>
            @endif
        </div>
    </div>
    <div class="col-md-8">
        <x-data-table title="Target Hafalan Berjalan">
            @forelse($santri->targetHafalan as $t)
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <div>
                        <p class="mb-0 fw-semibold small">{{ $t->surah->nama_surah }} ({{ $t->ayat_awal }}-{{ $t->ayat_akhir }})</p>
                        <div class="progress" style="height:6px;width:200px;">
                            <div class="progress-bar bg-success" style="width:{{ $t->persentase_progress }}%"></div>
                        </div>
                    </div>
                    <span class="badge badge-status-{{ $t->status }}">{{ $t->persentase_progress }}%</span>
                </div>
            @empty
                <x-empty-state message="Belum ada target hafalan." />
            @endforelse
        </x-data-table>

        <div class="mt-3">
            <x-data-table title="Riwayat Setoran Terakhir">
                @if($santri->setoran->isEmpty())
                    <x-empty-state message="Belum ada data setoran." />
                @else
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead><tr><th>Tanggal</th><th>Surah</th><th>Ayat</th><th>Nilai</th></tr></thead>
                        <tbody>
                        @foreach($santri->setoran as $s)
                            <tr>
                                <td>{{ $s->tanggal->format('d-m-Y') }}</td>
                                <td>{{ $s->surah->nama_surah }}</td>
                                <td>{{ $s->ayat_awal }}-{{ $s->ayat_akhir }}</td>
                                <td>{{ $s->nilai_akhir }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </x-data-table>
        </div>

        <div class="mt-3">
            <x-data-table title="Riwayat Nilai Semester">
                @if($santri->penilaian->isEmpty())
                    <x-empty-state message="Belum ada data penilaian semester." />
                @else
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead><tr><th>Semester</th><th>Nilai Akhir</th><th>Predikat</th></tr></thead>
                        <tbody>
                        @foreach($santri->penilaian as $p)
                            <tr>
                                <td>{{ $p->semester->nama }}</td>
                                <td>{{ $p->nilai_akhir }}</td>
                                <td><span class="badge badge-predikat-{{ $p->predikat }}">{{ $p->predikat }}</span></td>
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
