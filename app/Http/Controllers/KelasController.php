<?php

namespace App\Http\Controllers;

use App\Http\Requests\Kelas\StoreKelasRequest;
use App\Http\Requests\Kelas\UpdateKelasRequest;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Services\LogActivityService;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function __construct(private LogActivityService $logService) {}

    public function index(Request $request)
    {
        $kelas = Kelas::query()
            ->with(['waliKelas', 'tahunAjaran', 'santri'])
            ->withCount('santri')
            ->search($request->q)
            ->applySort($request->sort, $request->direction)
            ->paginate(10)
            ->withQueryString();

        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
        $guru = Guru::orderBy('nama')->get();
        $tahunAjaran = TahunAjaran::orderByDesc('nama')->get();

        return view('kelas.create', compact('guru', 'tahunAjaran'));
    }

    public function store(StoreKelasRequest $request)
    {
        $kelas = Kelas::create($request->validated());

        $this->logService->catat("Menambahkan kelas: {$kelas->nama_kelas}", 'kelas');

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function edit(Kelas $kelas)
    {
        $guru = Guru::orderBy('nama')->get();
        $tahunAjaran = TahunAjaran::orderByDesc('nama')->get();

        return view('kelas.edit', compact('kelas', 'guru', 'tahunAjaran'));
    }

    public function update(UpdateKelasRequest $request, Kelas $kelas)
    {
        $kelas->update($request->validated());

        $this->logService->catat("Memperbarui kelas: {$kelas->nama_kelas}", 'kelas');

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kelas)
    {
        if ($kelas->santri()->exists()) {
            return back()->with('error', 'Kelas tidak dapat dihapus karena masih memiliki santri.');
        }

        $nama = $kelas->nama_kelas;
        $kelas->delete();

        $this->logService->catat("Menghapus kelas: {$nama}", 'kelas');

        return back()->with('success', 'Data kelas berhasil dihapus.');
    }
}
