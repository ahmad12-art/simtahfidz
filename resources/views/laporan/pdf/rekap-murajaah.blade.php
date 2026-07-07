<!DOCTYPE html><html><head><meta charset="utf-8">@include('laporan.pdf._style')</head><body>
<div class="header"><h2>SIMTAHFIDZ</h2><p>{{ $judul }} — Dicetak: {{ now()->format('d-m-Y H:i') }}</p></div>
<table>
    <thead><tr><th>#</th><th>Tanggal</th><th>Santri</th><th>Guru</th><th>Surah</th><th>Ayat</th><th>Nilai</th></tr></thead>
    <tbody>
    @forelse($items as $i => $m)
        <tr>
            <td>{{ $i+1 }}</td><td>{{ $m->tanggal->format('d-m-Y') }}</td><td>{{ $m->santri->nama }}</td>
            <td>{{ $m->guru->nama }}</td><td>{{ $m->surah->nama_surah }}</td><td>{{ $m->ayat_awal }}-{{ $m->ayat_akhir }}</td><td>{{ $m->nilai_akhir }}</td>
        </tr>
    @empty
        <tr><td colspan="7" class="text-center">Tidak ada data</td></tr>
    @endforelse
    </tbody>
</table>
<div class="footer">SIMTAHFIDZ — Sistem Informasi Manajemen Hafalan Al-Qur'an</div>
</body></html>
