<?php

namespace App\Http\Controllers;

use App\Http\Requests\Santri\StoreSantriRequest;
use App\Http\Requests\Santri\UpdateSantriRequest;
use App\Models\Kelas;
use App\Models\Santri;
use App\Services\LogActivityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SantriController extends Controller
{
    public function __construct(private LogActivityService $logService) {}

    public function index(Request $request)
    {
        $santri = Santri::query()
            ->with('kelas')
            ->search($request->q)
            ->applyFilters(['kelas_id' => $request->kelas_id, 'status' => $request->status])
            ->applySort($request->sort, $request->direction)
            ->paginate(10)
            ->withQueryString();

        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('santri.index', compact('santri', 'kelas'));
    }

    public function create()
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('santri.create', compact('kelas'));
    }

    public function store(StoreSantriRequest $request)
    {
        $data = $request->validated();
        $data['qr_code'] = 'SIMTAHFIDZ-'.Str::upper(Str::random(10));

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('santri', 'public');
        }

        $santri = Santri::create($data);

        $this->logService->catat("Menambahkan data santri: {$santri->nama}", 'santri');

        return redirect()->route('santri.index')->with('success', 'Data santri berhasil ditambahkan.');
    }

    public function show(Santri $santri)
    {
        $this->authorize('view', $santri);

        $santri->load([
            'kelas',
            'targetHafalan.surah',
            'setoran' => fn ($q) => $q->latest()->take(15)->with('surah'),
            'penilaian.semester',
        ]);

        return view('santri.show', compact('santri'));
    }

    public function edit(Santri $santri)
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('santri.edit', compact('santri', 'kelas'));
    }

    public function update(UpdateSantriRequest $request, Santri $santri)
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            if ($santri->foto) {
                Storage::disk('public')->delete($santri->foto);
            }
            $data['foto'] = $request->file('foto')->store('santri', 'public');
        }

        $santri->update($data);

        $this->logService->catat("Memperbarui data santri: {$santri->nama}", 'santri');

        return redirect()->route('santri.index')->with('success', 'Data santri berhasil diperbarui.');
    }

    public function destroy(Santri $santri)
    {
        $nama = $santri->nama;
        $santri->delete();

        $this->logService->catat("Menghapus data santri: {$nama}", 'santri');

        return back()->with('success', 'Data santri berhasil dihapus.');
    }
}
