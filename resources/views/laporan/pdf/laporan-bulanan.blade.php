<!DOCTYPE html><html><head><meta charset="utf-8">@include('laporan.pdf._style')</head><body>
<div class="header"><h2>SIMTAHFIDZ</h2><p>{{ $judul }} — Dicetak: {{ now()->format('d-m-Y H:i') }}</p></div>
<table>
    <thead><tr><th>#</th><th>Tanggal</th><th>Santri</th><th>Kelas</th><th>Guru</th><th>Nilai</th></tr></thead>
    <tbody>
    @forelse($items as $i => $s)
        <tr><td>{{ $i+1 }}</td><td>{{ $s->tanggal->format('d-m-Y') }}</td><td>{{ $s->santri->nama }}</td><td>{{ $s->santri->kelas->nama_kelas ?? '-' }}</td><td>{{ $s->guru->nama }}</td><td>{{ $s->nilai_akhir }}</td></tr>
    @empty
        <tr><td colspan="6" class="text-center">Tidak ada data</td></tr>
    @endforelse
    </tbody>
</table>
<div class="footer">SIMTAHFIDZ — Sistem Informasi Manajemen Hafalan Al-Qur'an</div>
</body></html>
