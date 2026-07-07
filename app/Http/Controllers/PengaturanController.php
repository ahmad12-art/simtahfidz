<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\TahunAjaran;
use App\Services\LogActivityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class PengaturanController extends Controller
{
    public function __construct(private LogActivityService $logService) {}

    public function edit()
    {
        $tahunAjaran = TahunAjaran::orderByDesc('nama')->get();
        $semester = Semester::with('tahunAjaran')->orderByDesc('id')->get();

        return view('pengaturan.index', compact('tahunAjaran', 'semester'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'tahun_ajaran_aktif' => ['required', 'exists:tahun_ajaran,id'],
            'semester_aktif' => ['required', 'exists:semester,id'],
        ]);

        DB::transaction(function () use ($request) {
            TahunAjaran::query()->update(['aktif' => false]);
            TahunAjaran::whereKey($request->tahun_ajaran_aktif)->update(['aktif' => true]);

            Semester::query()->update(['aktif' => false]);
            Semester::whereKey($request->semester_aktif)->update(['aktif' => true]);
        });

        $this->logService->catat('Mengubah pengaturan tahun ajaran/semester aktif', 'pengaturan');

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }

    public function backup()
    {
        // Placeholder aman: memicu proses backup DB via artisan command kustom
        // (implementasikan App\Console\Commands\BackupDatabase sesuai driver DB produksi).
        Artisan::call('backup:database');

        $this->logService->catat('Menjalankan backup database', 'pengaturan');

        return back()->with('success', 'Backup database berhasil dijalankan.');
    }
}
