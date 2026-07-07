<!DOCTYPE html><html><head><meta charset="utf-8">@include('laporan.pdf._style')</head><body>
<div class="header"><h2>SIMTAHFIDZ</h2><p>{{ $judul }} — Dicetak: {{ now()->format('d-m-Y H:i') }}</p></div>
<table>
    <thead><tr><th>#</th><th>Nama</th><th>NIP</th><th>Total Setoran</th><th>Total Murajaah</th><th>Total Target</th></tr></thead>
    <tbody>
    @forelse($items as $i => $g)
        <tr><td>{{ $i+1 }}</td><td>{{ $g->nama }}</td><td>{{ $g->nip }}</td><td>{{ $g->setoran_count }}</td><td>{{ $g->murajaah_count }}</td><td>{{ $g->target_hafalan_count }}</td></tr>
    @empty
        <tr><td colspan="6" class="text-center">Tidak ada data</td></tr>
    @endforelse
    </tbody>
</table>
<div class="footer">SIMTAHFIDZ — Sistem Informasi Manajemen Hafalan Al-Qur'an</div>
</body></html>
