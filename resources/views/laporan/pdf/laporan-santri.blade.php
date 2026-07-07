<!DOCTYPE html><html><head><meta charset="utf-8">@include('laporan.pdf._style')</head><body>
<div class="header"><h2>SIMTAHFIDZ</h2><p>{{ $judul }} — Dicetak: {{ now()->format('d-m-Y H:i') }}</p></div>
<table>
    <thead><tr><th>#</th><th>NIS</th><th>Nama</th><th>Kelas</th><th>Total Setoran</th><th>Total Murajaah</th></tr></thead>
    <tbody>
    @forelse($items as $i => $s)
        <tr><td>{{ $i+1 }}</td><td>{{ $s->nis }}</td><td>{{ $s->nama }}</td><td>{{ $s->kelas->nama_kelas ?? '-' }}</td><td>{{ $s->setoran_count }}</td><td>{{ $s->murajaah_count }}</td></tr>
    @empty
        <tr><td colspan="6" class="text-center">Tidak ada data</td></tr>
    @endforelse
    </tbody>
</table>
<div class="footer">SIMTAHFIDZ — Sistem Informasi Manajemen Hafalan Al-Qur'an</div>
</body></html>
