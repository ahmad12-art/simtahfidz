<?php

namespace App\Http\Controllers;

use App\Http\Requests\Surah\StoreSurahRequest;
use App\Http\Requests\Surah\UpdateSurahRequest;
use App\Models\Surah;
use App\Services\LogActivityService;
use Illuminate\Http\Request;

class SurahController extends Controller
{
    public function __construct(private LogActivityService $logService) {}

    public function index(Request $request)
    {
        $surah = Surah::query()
            ->search($request->q)
            ->applyFilters(['juz' => $request->juz, 'kategori' => $request->kategori])
            ->applySort($request->sort ?? 'nomor_surah', $request->direction ?? 'asc')
            ->paginate(15)
            ->withQueryString();

        return view('surah.index', compact('surah'));
    }

    public function create()
    {
        return view('surah.create');
    }

    public function store(StoreSurahRequest $request)
    {
        $surah = Surah::create($request->validated());

        $this->logService->catat("Menambahkan surah: {$surah->nama_surah}", 'surah');

        return redirect()->route('surah.index')->with('success', 'Data surah berhasil ditambahkan.');
    }

    public function edit(Surah $surah)
    {
        return view('surah.edit', compact('surah'));
    }

    public function update(UpdateSurahRequest $request, Surah $surah)
    {
        $surah->update($request->validated());

        $this->logService->catat("Memperbarui surah: {$surah->nama_surah}", 'surah');

        return redirect()->route('surah.index')->with('success', 'Data surah berhasil diperbarui.');
    }

    public function destroy(Surah $surah)
    {
        $nama = $surah->nama_surah;
        $surah->delete();

        $this->logService->catat("Menghapus surah: {$nama}", 'surah');

        return back()->with('success', 'Data surah berhasil dihapus.');
    }
}
