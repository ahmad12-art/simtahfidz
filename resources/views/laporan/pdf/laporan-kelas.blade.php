<!DOCTYPE html><html><head><meta charset="utf-8">@include('laporan.pdf._style')</head><body>
<div class="header"><h2>SIMTAHFIDZ</h2><p>{{ $judul }} — Dicetak: {{ now()->format('d-m-Y H:i') }}</p></div>
<table>
    <thead><tr><th>#</th><th>Kelas</th><th>Wali Kelas</th><th>Jumlah Santri</th></tr></thead>
    <tbody>
    @forelse($items as $i => $k)
        <tr><td>{{ $i+1 }}</td><td>{{ $k->nama_kelas }}</td><td>{{ $k->waliKelas->nama ?? '-' }}</td><td>{{ $k->santri_count }}</td></tr>
    @empty
        <tr><td colspan="4" class="text-center">Tidak ada data</td></tr>
    @endforelse
    </tbody>
</table>
<div class="footer">SIMTAHFIDZ — Sistem Informasi Manajemen Hafalan Al-Qur'an</div>
</body></html>
