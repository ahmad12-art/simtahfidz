<?php

namespace App\Http\Controllers;

use App\Http\Requests\Penilaian\StorePenilaianRequest;
use App\Http\Requests\Penilaian\UpdatePenilaianRequest;
use App\Models\Penilaian;
use App\Models\Santri;
use App\Models\Semester;
use App\Services\LogActivityService;
use App\Services\PenilaianService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PenilaianController extends Controller
{
    public function __construct(
        private LogActivityService $logService,
        private PenilaianService $penilaianService,
    ) {}

    public function index(Request $request)
    {
        $penilaian = Penilaian::query()
            ->with(['santri', 'semester'])
            ->applyFilters(['semester_id' => $request->semester_id, 'predikat' => $request->predikat])
            ->applySort($request->sort, $request->direction)
            ->paginate(10)
            ->withQueryString();

        $semester = Semester::with('tahunAjaran')->orderByDesc('id')->get();

        return view('penilaian.index', compact('penilaian', 'semester'));
    }

    public function create()
    {
        $santri = Santri::orderBy('nama')->get();
        $semester = Semester::with('tahunAjaran')->orderByDesc('id')->get();

        return view('penilaian.create', compact('santri', 'semester'));
    }

    public function store(StorePenilaianRequest $request)
    {
        $data = $request->validated();

        $exists = Penilaian::where('santri_id', $data['santri_id'])
            ->where('semester_id', $data['semester_id'])
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'santri_id' => 'Santri ini sudah memiliki nilai pada semester tersebut.',
            ]);
        }

        $data['nilai_akhir'] = $this->penilaianService->hitungNilaiSemester(
            $data['kelancaran'], $data['tajwid'], $data['makhraj'], $data['adab'], $data['kehadiran']
        );
        $data['predikat'] = $this->penilaianService->tentukanPredikat($data['nilai_akhir']);

        $penilaian = Penilaian::create($data);

        $this->logService->catat("Menambahkan penilaian {$penilaian->santri->nama}", 'penilaian');

        return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil disimpan.');
    }

    public function edit(Penilaian $penilaian)
    {
        $santri = Santri::orderBy('nama')->get();
        $semester = Semester::with('tahunAjaran')->orderByDesc('id')->get();

        return view('penilaian.edit', compact('penilaian', 'santri', 'semester'));
    }

    public function update(UpdatePenilaianRequest $request, Penilaian $penilaian)
    {
        $data = $request->validated();

        $data['nilai_akhir'] = $this->penilaianService->hitungNilaiSemester(
            $data['kelancaran'], $data['tajwid'], $data['makhraj'], $data['adab'], $data['kehadiran']
        );
        $data['predikat'] = $this->penilaianService->tentukanPredikat($data['nilai_akhir']);

        $penilaian->update($data);

        $this->logService->catat("Memperbarui penilaian {$penilaian->santri->nama}", 'penilaian');

        return redirect()->route('penilaian.index')->with('success', 'Penilaian berhasil diperbarui.');
    }

    public function destroy(Penilaian $penilaian)
    {
        $penilaian->delete();

        $this->logService->catat('Menghapus data penilaian', 'penilaian');

        return back()->with('success', 'Data penilaian berhasil dihapus.');
    }
}
