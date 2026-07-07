<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\LogAktivitas;
use App\Models\Murajaah;
use App\Models\Santri;
use App\Models\Setoran;
use App\Models\TargetHafalan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->isAdmin();
        $guruId = $user->guru?->id;

        $setoranQuery = Setoran::query()->when(! $isAdmin, fn ($q) => $q->where('guru_id', $guruId));
        $targetQuery = TargetHafalan::query()->when(! $isAdmin, fn ($q) => $q->where('guru_id', $guruId));
        $murajaahQuery = Murajaah::query()->when(! $isAdmin, fn ($q) => $q->where('guru_id', $guruId));

        $stats = [
            'total_guru' => $isAdmin ? Guru::count() : null,
            'total_santri' => $isAdmin ? Santri::count() : Santri::whereHas('setoran', fn ($q) => $q->where('guru_id', $guruId))->count(),
            'total_kelas' => $isAdmin ? Kelas::count() : null,
            'setoran_hari_ini' => (clone $setoranQuery)->whereDate('tanggal', today())->count(),
            'target_aktif' => (clone $targetQuery)->where('status', 'berjalan')->count(),
            'target_selesai' => (clone $targetQuery)->where('status', 'selesai')->count(),
            'murajaah_hari_ini' => (clone $murajaahQuery)->whereDate('tanggal', today())->count(),
            'rata_rata_nilai' => round((clone $setoranQuery)->avg('nilai_akhir') ?? 0, 1),
        ];

        // Grafik setoran bulanan (6 bulan terakhir)
        $bulanLabels = [];
        $bulanData = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);
            $bulanLabels[] = $bulan->translatedFormat('M Y');
            $bulanData[] = (clone $setoranQuery)
                ->whereYear('tanggal', $bulan->year)
                ->whereMonth('tanggal', $bulan->month)
                ->count();
        }

        // Grafik status target hafalan
        $targetStatus = (clone $targetQuery)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // Grafik rata-rata nilai per kelas
        $nilaiPerKelas = Kelas::query()
            ->withCount('santri')
            ->with(['santri.setoran' => fn ($q) => $q->when(! $isAdmin, fn ($q2) => $q2->where('guru_id', $guruId))])
            ->get()
            ->map(fn ($kelas) => [
                'nama' => $kelas->nama_kelas,
                'rata_rata' => round($kelas->santri->flatMap->setoran->avg('nilai_akhir') ?? 0, 1),
            ])
            ->filter(fn ($k) => $k['rata_rata'] > 0)
            ->values();

        // Santri teraktif (top 5 berdasarkan jumlah setoran)
        $santriTeraktif = Santri::query()
            ->withCount(['setoran' => fn ($q) => $q->when(! $isAdmin, fn ($q2) => $q2->where('guru_id', $guruId))])
            ->orderByDesc('setoran_count')
            ->take(5)
            ->get();

        $aktivitasTerbaru = LogAktivitas::with('user')
            ->when(! $isAdmin, fn ($q) => $q->where('user_id', $user->id))
            ->latest()
            ->take(8)
            ->get();

        return view('dashboard.index', [
            'stats' => $stats,
            'bulanLabels' => $bulanLabels,
            'bulanData' => $bulanData,
            'targetStatus' => $targetStatus,
            'nilaiPerKelas' => $nilaiPerKelas,
            'santriTeraktif' => $santriTeraktif,
            'aktivitasTerbaru' => $aktivitasTerbaru,
            'isAdmin' => $isAdmin,
        ]);
    }
}
