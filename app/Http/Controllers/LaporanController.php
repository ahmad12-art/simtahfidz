<?php

namespace App\Http\Controllers;

use App\Exports\MurajaahExport;
use App\Exports\PenilaianExport;
use App\Exports\SantriExport;
use App\Exports\SetoranExport;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Murajaah;
use App\Models\Penilaian;
use App\Models\Semester;
use App\Models\Setoran;
use App\Models\TargetHafalan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    /** Daftar laporan yang tersedia beserta judulnya (dipakai index & validasi $jenis). */
    private array $jenisLaporan = [
        'progress-hafalan' => 'Progress Hafalan',
        'rekap-setoran' => 'Rekap Setoran',
        'rekap-murajaah' => 'Rekap Murajaah',
        'rekap-nilai' => 'Rekap Nilai',
        'laporan-guru' => 'Laporan Kinerja Guru',
        'laporan-santri' => 'Laporan Per Santri',
        'laporan-kelas' => 'Laporan Per Kelas',
        'laporan-bulanan' => 'Laporan Bulanan',
        'laporan-tahunan' => 'Laporan Tahunan',
    ];

    public function index()
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $guru = Guru::orderBy('nama')->get();
        $semester = Semester::with('tahunAjaran')->orderByDesc('id')->get();

        return view('laporan.index', [
            'jenisLaporan' => $this->jenisLaporan,
            'kelas' => $kelas,
            'guru' => $guru,
            'semester' => $semester,
        ]);
    }

    public function preview(Request $request, string $jenis)
    {
        abort_unless(array_key_exists($jenis, $this->jenisLaporan), 404);

        $data = $this->buildData($jenis, $request);

        return view("laporan.preview.{$jenis}", $data + [
            'judul' => $this->jenisLaporan[$jenis],
            'filters' => $request->all(),
        ]);
    }

    public function exportPdf(Request $request, string $jenis)
    {
        abort_unless(array_key_exists($jenis, $this->jenisLaporan), 404);

        $data = $this->buildData($jenis, $request);

        $pdf = Pdf::loadView("laporan.pdf.{$jenis}", $data + [
            'judul' => $this->jenisLaporan[$jenis],
            'filters' => $request->all(),
        ])->setPaper('a4', 'landscape');

        return $pdf->download("{$jenis}-".now()->format('Ymd_His').'.pdf');
    }

    public function exportExcel(Request $request, string $jenis)
    {
        $filters = $request->only(['guru_id', 'kelas_id', 'semester_id', 'tanggal_awal', 'tanggal_akhir']);

        $export = match ($jenis) {
            'rekap-setoran' => new SetoranExport($filters),
            'rekap-murajaah' => new MurajaahExport($filters),
            'rekap-nilai' => new PenilaianExport($filters),
            'laporan-santri' => new SantriExport,
            default => abort(404, 'Jenis laporan ini belum mendukung export Excel.'),
        };

        return Excel::download($export, "{$jenis}-".now()->format('Ymd_His').'.xlsx');
    }

    private function buildData(string $jenis, Request $request): array
    {
        $user = Auth::user();
        $isAdmin = $user->isAdmin();
        $guruId = $isAdmin ? $request->guru_id : $user->guru?->id;

        return match ($jenis) {
            'progress-hafalan' => [
                'items' => TargetHafalan::with(['santri.kelas', 'guru', 'surah'])
                    ->when($guruId, fn ($q) => $q->where('guru_id', $guruId))
                    ->when($request->kelas_id, fn ($q) => $q->whereHas('santri', fn ($s) => $s->where('kelas_id', $request->kelas_id)))
                    ->when($request->status, fn ($q) => $q->where('status', $request->status))
                    ->get(),
            ],
            'rekap-setoran' => [
                'items' => Setoran::with(['santri.kelas', 'guru', 'surah'])
                    ->when($guruId, fn ($q) => $q->where('guru_id', $guruId))
                    ->when($request->kelas_id, fn ($q) => $q->whereHas('santri', fn ($s) => $s->where('kelas_id', $request->kelas_id)))
                    ->when($request->tanggal_awal, fn ($q) => $q->whereDate('tanggal', '>=', $request->tanggal_awal))
                    ->when($request->tanggal_akhir, fn ($q) => $q->whereDate('tanggal', '<=', $request->tanggal_akhir))
                    ->orderBy('tanggal')
                    ->get(),
            ],
            'rekap-murajaah' => [
                'items' => Murajaah::with(['santri.kelas', 'guru', 'surah'])
                    ->when($guruId, fn ($q) => $q->where('guru_id', $guruId))
                    ->when($request->tanggal_awal, fn ($q) => $q->whereDate('tanggal', '>=', $request->tanggal_awal))
                    ->when($request->tanggal_akhir, fn ($q) => $q->whereDate('tanggal', '<=', $request->tanggal_akhir))
                    ->orderBy('tanggal')
                    ->get(),
            ],
            'rekap-nilai', 'laporan-tahunan' => [
                'items' => Penilaian::with(['santri.kelas', 'semester'])
                    ->when($request->semester_id, fn ($q) => $q->where('semester_id', $request->semester_id))
                    ->when($request->kelas_id, fn ($q) => $q->whereHas('santri', fn ($s) => $s->where('kelas_id', $request->kelas_id)))
                    ->get(),
            ],
            'laporan-guru' => [
                'items' => Guru::withCount(['setoran', 'murajaah', 'targetHafalan'])->get(),
            ],
            'laporan-santri' => [
                'items' => \App\Models\Santri::with('kelas')
                    ->when($request->kelas_id, fn ($q) => $q->where('kelas_id', $request->kelas_id))
                    ->withCount(['setoran', 'murajaah'])
                    ->get(),
            ],
            'laporan-kelas' => [
                'items' => Kelas::with(['waliKelas', 'santri'])->withCount('santri')->get(),
            ],
            'laporan-bulanan' => [
                'items' => Setoran::with(['santri.kelas', 'guru'])
                    ->when($guruId, fn ($q) => $q->where('guru_id', $guruId))
                    ->whereMonth('tanggal', $request->bulan ?? now()->month)
                    ->whereYear('tanggal', $request->tahun ?? now()->year)
                    ->get(),
            ],
            default => ['items' => collect()],
        };
    }
}
