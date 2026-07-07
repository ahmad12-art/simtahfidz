<?php

namespace App\Http\Controllers;

use App\Http\Requests\TargetHafalan\StoreTargetHafalanRequest;
use App\Http\Requests\TargetHafalan\UpdateTargetHafalanRequest;
use App\Models\Guru;
use App\Models\Santri;
use App\Models\Surah;
use App\Models\TargetHafalan;
use App\Services\LogActivityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TargetHafalanController extends Controller
{
    public function __construct(private LogActivityService $logService) {}

    public function index(Request $request)
    {
        $user = Auth::user();

        $target = TargetHafalan::query()
            ->with(['santri', 'guru', 'surah'])
            ->when(! $user->isAdmin(), fn ($q) => $q->where('guru_id', $user->guru?->id))
            ->status($request->status)
            ->applyFilters(['santri_id' => $request->santri_id])
            ->applySort($request->sort, $request->direction)
            ->paginate(10)
            ->withQueryString();

        return view('target-hafalan.index', compact('target'));
    }

    public function create()
    {
        $santri = Santri::orderBy('nama')->get();
        $guru = Guru::orderBy('nama')->get();
        $surah = Surah::orderBy('nomor_surah')->get();

        return view('target-hafalan.create', compact('santri', 'guru', 'surah'));
    }

    public function store(StoreTargetHafalanRequest $request)
    {
        $target = TargetHafalan::create($request->validated() + ['status' => 'berjalan']);

        $this->logService->catat("Menambahkan target hafalan untuk {$target->santri->nama}", 'target-hafalan');

        return redirect()->route('target-hafalan.index')->with('success', 'Target hafalan berhasil ditambahkan.');
    }

    public function edit(TargetHafalan $targetHafalan)
    {
        $this->authorize('view', $targetHafalan);

        $santri = Santri::orderBy('nama')->get();
        $guru = Guru::orderBy('nama')->get();
        $surah = Surah::orderBy('nomor_surah')->get();

        return view('target-hafalan.edit', compact('targetHafalan', 'santri', 'guru', 'surah'));
    }

    public function update(UpdateTargetHafalanRequest $request, TargetHafalan $targetHafalan)
    {
        $this->authorize('update', $targetHafalan);

        $targetHafalan->update($request->validated());

        $this->logService->catat("Memperbarui target hafalan {$targetHafalan->santri->nama}", 'target-hafalan');

        return redirect()->route('target-hafalan.index')->with('success', 'Target hafalan berhasil diperbarui.');
    }

    public function destroy(TargetHafalan $targetHafalan)
    {
        $this->authorize('delete', $targetHafalan);

        $targetHafalan->delete();

        $this->logService->catat('Menghapus target hafalan', 'target-hafalan');

        return back()->with('success', 'Target hafalan berhasil dihapus.');
    }
}
