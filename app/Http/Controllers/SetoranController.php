<?php

namespace App\Http\Controllers;

use App\Http\Requests\Setoran\StoreSetoranRequest;
use App\Http\Requests\Setoran\UpdateSetoranRequest;
use App\Models\Guru;
use App\Models\Santri;
use App\Models\Setoran;
use App\Models\Surah;
use App\Models\TargetHafalan;
use App\Services\LogActivityService;
use App\Services\PenilaianService;
use App\Services\ProgressTargetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SetoranController extends Controller
{
    public function __construct(
        private LogActivityService $logService,
        private PenilaianService $penilaianService,
        private ProgressTargetService $progressService,
    ) {}

    public function index(Request $request)
    {
        $user = Auth::user();

        $setoran = Setoran::query()
            ->with(['santri', 'guru', 'surah'])
            ->when(! $user->isAdmin(), fn ($q) => $q->where('guru_id', $user->guru?->id))
            ->applyFilters([
                'santri_id' => $request->santri_id,
                'status' => $request->status,
            ])
            ->when($request->tanggal_awal, fn ($q) => $q->whereDate('tanggal', '>=', $request->tanggal_awal))
            ->when($request->tanggal_akhir, fn ($q) => $q->whereDate('tanggal', '<=', $request->tanggal_akhir))
            ->applySort($request->sort ?? 'tanggal', $request->direction ?? 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('setoran.index', compact('setoran'));
    }

    public function create()
    {
        $santri = Santri::orderBy('nama')->get();
        $guru = Guru::orderBy('nama')->get();
        $surah = Surah::orderBy('nomor_surah')->get();
        $target = TargetHafalan::where('status', 'berjalan')->with('santri')->get();

        return view('setoran.create', compact('santri', 'guru', 'surah', 'target'));
    }

    public function store(StoreSetoranRequest $request)
    {
        DB::transaction(function () use ($request) {
            $data = $request->validated();

            $data['nilai_akhir'] = $this->penilaianService->hitungNilaiAkhir(
                $data['nilai_kelancaran'],
                $data['nilai_tajwid'],
                $data['nilai_makhraj'],
                $data['nilai_adab'],
            );

            $setoran = Setoran::create($data);

            if ($setoran->target_hafalan_id) {
                $this->progressService->updateFromSetoran($setoran->targetHafalan);
            }

            $this->logService->catat("Menambahkan setoran hafalan {$setoran->santri->nama}", 'setoran');
        });

        return redirect()->route('setoran.index')->with('success', 'Setoran hafalan berhasil disimpan.');
    }

    public function edit(Setoran $setoran)
    {
        $this->authorize('update', $setoran);

        $santri = Santri::orderBy('nama')->get();
        $guru = Guru::orderBy('nama')->get();
        $surah = Surah::orderBy('nomor_surah')->get();
        $target = TargetHafalan::where('status', 'berjalan')->orWhere('id', $setoran->target_hafalan_id)->with('santri')->get();

        return view('setoran.edit', compact('setoran', 'santri', 'guru', 'surah', 'target'));
    }

    public function update(UpdateSetoranRequest $request, Setoran $setoran)
    {
        $this->authorize('update', $setoran);

        DB::transaction(function () use ($request, $setoran) {
            $data = $request->validated();

            $data['nilai_akhir'] = $this->penilaianService->hitungNilaiAkhir(
                $data['nilai_kelancaran'],
                $data['nilai_tajwid'],
                $data['nilai_makhraj'],
                $data['nilai_adab'],
            );

            $setoran->update($data);

            if ($setoran->target_hafalan_id) {
                $this->progressService->updateFromSetoran($setoran->targetHafalan);
            }

            $this->logService->catat("Memperbarui setoran hafalan {$setoran->santri->nama}", 'setoran');
        });

        return redirect()->route('setoran.index')->with('success', 'Setoran hafalan berhasil diperbarui.');
    }

    public function destroy(Setoran $setoran)
    {
        $this->authorize('delete', $setoran);

        $target = $setoran->targetHafalan;
        $setoran->delete();

        if ($target) {
            $this->progressService->updateFromSetoran($target);
        }

        $this->logService->catat('Menghapus data setoran hafalan', 'setoran');

        return back()->with('success', 'Data setoran berhasil dihapus.');
    }
}
