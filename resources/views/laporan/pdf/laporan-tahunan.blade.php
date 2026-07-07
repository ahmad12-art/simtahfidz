<!DOCTYPE html><html><head><meta charset="utf-8">@include('laporan.pdf._style')</head><body>
<div class="header"><h2>SIMTAHFIDZ</h2><p>{{ $judul }} — Dicetak: {{ now()->format('d-m-Y H:i') }}</p></div>
<table>
    <thead><tr><th>#</th><th>Santri</th><th>Semester</th><th>Nilai Akhir</th><th>Predikat</th></tr></thead>
    <tbody>
    @forelse($items as $i => $p)
        <tr><td>{{ $i+1 }}</td><td>{{ $p->santri->nama }}</td><td>{{ $p->semester->nama }}</td><td>{{ $p->nilai_akhir }}</td><td>{{ $p->predikat }}</td></tr>
    @empty
        <tr><td colspan="5" class="text-center">Tidak ada data</td></tr>
    @endforelse
    </tbody>
</table>
<div class="footer">SIMTAHFIDZ — Sistem Informasi Manajemen Hafalan Al-Qur'an</div>
</body></html>
