<!DOCTYPE html><html><head><meta charset="utf-8">@include('laporan.pdf._style')</head><body>
<div class="header">
    <h2>SIMTAHFIDZ</h2>
    <p>{{ $judul }} — Dicetak: {{ now()->format('d-m-Y H:i') }}</p>
</div>
<table>
    <thead><tr><th>#</th><th>Santri</th><th>Kelas</th><th>Guru</th><th>Surah</th><th>Ayat</th><th>Progress</th><th>Status</th></tr></thead>
    <tbody>
    @forelse($items as $i => $t)
        <tr>
            <td>{{ $i+1 }}</td><td>{{ $t->santri->nama }}</td><td>{{ $t->santri->kelas->nama_kelas ?? '-' }}</td>
            <td>{{ $t->guru->nama }}</td><td>{{ $t->surah->nama_surah }}</td><td>{{ $t->ayat_awal }}-{{ $t->ayat_akhir }}</td>
            <td>{{ $t->persentase_progress }}%</td><td>{{ ucfirst($t->status) }}</td>
        </tr>
    @empty
        <tr><td colspan="8" class="text-center">Tidak ada data</td></tr>
    @endforelse
    </tbody>
</table>
<div class="footer">SIMTAHFIDZ — Sistem Informasi Manajemen Hafalan Al-Qur'an</div>
</body></html>
