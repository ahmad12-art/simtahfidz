@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold mb-0">Selamat datang, {{ auth()->user()->name }} 👋</h4>
        <p class="text-muted small mb-0">Berikut ringkasan aktivitas hafalan hari ini.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('setoran.create') }}" class="btn btn-emerald btn-sm"><i class="bi bi-plus-lg me-1"></i>Setoran</a>
        <a href="{{ route('murajaah.create') }}" class="btn btn-outline-emerald btn-sm"><i class="bi bi-plus-lg me-1"></i>Murajaah</a>
        <a href="{{ route('laporan.index') }}" class="btn btn-outline-emerald btn-sm"><i class="bi bi-file-earmark-bar-graph me-1"></i>Laporan</a>
    </div>
</div>

<div class="row g-3 mb-4">
    @if($isAdmin)
    <div class="col-6 col-md-3">
        <x-card-stat icon="bi-person-badge" label="Total Guru" :value="$stats['total_guru']" color="emerald" />
    </div>
    <div class="col-6 col-md-3">
        <x-card-stat icon="bi-people" label="Total Santri" :value="$stats['total_santri']" color="blue" />
    </div>
    <div class="col-6 col-md-3">
        <x-card-stat icon="bi-door-open" label="Total Kelas" :value="$stats['total_kelas']" color="gold" />
    </div>
    @else
    <div class="col-6 col-md-3">
        <x-card-stat icon="bi-people" label="Santri Binaan" :value="$stats['total_santri']" color="blue" />
    </div>
    @endif
    <div class="col-6 col-md-3">
        <x-card-stat icon="bi-mic" label="Setoran Hari Ini" :value="$stats['setoran_hari_ini']" color="emerald" />
    </div>
    <div class="col-6 col-md-3">
        <x-card-stat icon="bi-bullseye" label="Target Aktif" :value="$stats['target_aktif']" color="gold" />
    </div>
    <div class="col-6 col-md-3">
        <x-card-stat icon="bi-check2-circle" label="Target Selesai" :value="$stats['target_selesai']" color="emerald" />
    </div>
    <div class="col-6 col-md-3">
        <x-card-stat icon="bi-arrow-repeat" label="Murajaah Hari Ini" :value="$stats['murajaah_hari_ini']" color="blue" />
    </div>
    <div class="col-6 col-md-3">
        <x-card-stat icon="bi-graph-up" label="Rata-rata Nilai" :value="$stats['rata_rata_nilai']" color="gold" />
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-12 col-lg-7">
        <div class="chart-card">
            <h6 class="fw-bold mb-3">Grafik Setoran Bulanan</h6>
            <canvas id="chartSetoranBulanan" height="110"></canvas>
        </div>
    </div>
    <div class="col-12 col-lg-5">
        <div class="chart-card">
            <h6 class="fw-bold mb-3">Status Target Hafalan</h6>
            <canvas id="chartTargetStatus" height="110"></canvas>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-12 col-lg-7">
        <div class="chart-card">
            <h6 class="fw-bold mb-3">Rata-rata Nilai per Kelas</h6>
            @if($nilaiPerKelas->isEmpty())
                <x-empty-state message="Belum ada data nilai untuk ditampilkan." />
            @else
                <canvas id="chartNilaiKelas" height="110"></canvas>
            @endif
        </div>
    </div>
    <div class="col-12 col-lg-5">
        <div class="chart-card h-100">
            <h6 class="fw-bold mb-3">Santri Teraktif</h6>
            @forelse($santriTeraktif as $s)
                <div class="d-flex align-items-center justify-content-between py-2 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <img src="https://ui-avatars.com/api/?background=059669&color=fff&name={{ urlencode($s->nama) }}" class="avatar-table">
                        <span class="small fw-semibold">{{ $s->nama }}</span>
                    </div>
                    <span class="badge bg-light text-dark">{{ $s->setoran_count }} setoran</span>
                </div>
            @empty
                <x-empty-state message="Belum ada data setoran." />
            @endforelse
        </div>
    </div>
</div>

<div class="content-card">
    <div class="card-body">
        <h6 class="fw-bold mb-3">Aktivitas Terbaru</h6>
        @forelse($aktivitasTerbaru as $log)
            <div class="d-flex gap-3 py-2 border-bottom">
                <i class="bi bi-clock-history text-muted"></i>
                <div>
                    <p class="small mb-0"><strong>{{ $log->user->name ?? 'Sistem' }}</strong> — {{ $log->aktivitas }}</p>
                    <p class="small text-muted mb-0">{{ $log->created_at->diffForHumans() }}</p>
                </div>
            </div>
        @empty
            <x-empty-state message="Belum ada aktivitas tercatat." />
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
    new Chart(document.getElementById('chartSetoranBulanan'), {
        type: 'line',
        data: {
            labels: @json($bulanLabels),
            datasets: [{
                label: 'Jumlah Setoran',
                data: @json($bulanData),
                borderColor: '#059669',
                backgroundColor: 'rgba(5,150,105,0.12)',
                fill: true,
                tension: 0.35,
            }]
        },
        options: { plugins: { legend: { display: false } }, responsive: true }
    });

    new Chart(document.getElementById('chartTargetStatus'), {
        type: 'doughnut',
        data: {
            labels: ['Berjalan', 'Selesai', 'Terlambat'],
            datasets: [{
                data: [
                    {{ $targetStatus['berjalan'] ?? 0 }},
                    {{ $targetStatus['selesai'] ?? 0 }},
                    {{ $targetStatus['terlambat'] ?? 0 }}
                ],
                backgroundColor: ['#fbbf24', '#059669', '#ef4444'],
            }]
        },
        options: { responsive: true }
    });

    @if($nilaiPerKelas->isNotEmpty())
    new Chart(document.getElementById('chartNilaiKelas'), {
        type: 'bar',
        data: {
            labels: @json($nilaiPerKelas->pluck('nama')),
            datasets: [{
                label: 'Rata-rata Nilai',
                data: @json($nilaiPerKelas->pluck('rata_rata')),
                backgroundColor: '#d4af37',
                borderRadius: 6,
            }]
        },
        options: { plugins: { legend: { display: false } }, responsive: true }
    });
    @endif
</script>
@endpush
