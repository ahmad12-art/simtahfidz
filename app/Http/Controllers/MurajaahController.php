<?php

namespace App\Http\Controllers;

use App\Http\Requests\Murajaah\StoreMurajaahRequest;
use App\Http\Requests\Murajaah\UpdateMurajaahRequest;
use App\Models\Guru;
use App\Models\Murajaah;
use App\Models\Santri;
use App\Models\Surah;
use App\Services\LogActivityService;
use App\Services\PenilaianService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MurajaahController extends Controller
{
    public function __construct(
        private LogActivityService $logService,
        private PenilaianService $penilaianService,
    ) {}

    public function index(Request $request)
    {
        $user = Auth::user();

        $murajaah = Murajaah::query()
            ->with(['santri', 'guru', 'surah'])
            ->when(! $user->isAdmin(), fn ($q) => $q->where('guru_id', $user->guru?->id))
            ->applyFilters(['santri_id' => $request->santri_id, 'status' => $request->status])
            ->when($request->tanggal_awal, fn ($q) => $q->whereDate('tanggal', '>=', $request->tanggal_awal))
            ->when($request->tanggal_akhir, fn ($q) => $q->whereDate('tanggal', '<=', $request->tanggal_akhir))
            ->applySort($request->sort ?? 'tanggal', $request->direction ?? 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('murajaah.index', compact('murajaah'));
    }

    public function create()
    {
        $santri = Santri::orderBy('nama')->get();
        $guru = Guru::orderBy('nama')->get();
        $surah = Surah::orderBy('nomor_surah')->get();

        return view('murajaah.create', compact('santri', 'guru', 'surah'));
    }

    public function store(StoreMurajaahRequest $request)
    {
        $data = $request->validated();
        $data['nilai_akhir'] = $this->penilaianService->hitungNilaiAkhir(
            $data['nilai_kelancaran'], $data['nilai_tajwid'], $data['nilai_makhraj']
        );

        $murajaah = Murajaah::create($data);

        $this->logService->catat("Menambahkan murajaah {$murajaah->santri->nama}", 'murajaah');

        return redirect()->route('murajaah.index')->with('success', 'Data murajaah berhasil disimpan.');
    }

    public function edit(Murajaah $murajaah)
    {
        $santri = Santri::orderBy('nama')->get();
        $guru = Guru::orderBy('nama')->get();
        $surah = Surah::orderBy('nomor_surah')->get();

        return view('murajaah.edit', compact('murajaah', 'santri', 'guru', 'surah'));
    }

    public function update(UpdateMurajaahRequest $request, Murajaah $murajaah)
    {
        $data = $request->validated();
        $data['nilai_akhir'] = $this->penilaianService->hitungNilaiAkhir(
            $data['nilai_kelancaran'], $data['nilai_tajwid'], $data['nilai_makhraj']
        );

        $murajaah->update($data);

        $this->logService->catat("Memperbarui murajaah {$murajaah->santri->nama}", 'murajaah');

        return redirect()->route('murajaah.index')->with('success', 'Data murajaah berhasil diperbarui.');
    }

    public function destroy(Murajaah $murajaah)
    {
        $murajaah->delete();

        $this->logService->catat('Menghapus data murajaah', 'murajaah');

        return back()->with('success', 'Data murajaah berhasil dihapus.');
    }
}
