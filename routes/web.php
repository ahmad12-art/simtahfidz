<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\MurajaahController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\SetoranController;
use App\Http\Controllers\SurahController;
use App\Http\Controllers\TargetHafalanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

// ==================== GUEST ====================
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store'])->name('login.store');

    Route::get('forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'edit'])->name('password.reset');
    Route::post('reset-password', [ForgotPasswordController::class, 'update'])->name('password.update');
});

// ==================== AUTH + ACTIVE ACCOUNT ====================
Route::middleware(['auth', 'active', 'log.activity'])->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profil', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::patch('notifikasi/{notifikasi}/baca', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.read');

    // ---- Modul yang bisa diakses Admin & Guru (dibatasi lanjut via Policy) ----
    Route::resource('target-hafalan', TargetHafalanController::class)->except(['show']);
    Route::resource('setoran', SetoranController::class)->except(['show']);
    Route::resource('murajaah', MurajaahController::class)->except(['show']);
    Route::resource('penilaian', PenilaianController::class)->except(['show']);

    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/{jenis}', [LaporanController::class, 'preview'])->name('preview');
        Route::get('/{jenis}/pdf', [LaporanController::class, 'exportPdf'])->name('pdf');
        Route::get('/{jenis}/excel', [LaporanController::class, 'exportExcel'])->name('excel');
    });

    // ---- Modul khusus Admin ----
    Route::middleware('role:admin')->group(function () {
        Route::resource('guru', GuruController::class);
        Route::resource('santri', SantriController::class);
        Route::resource('kelas', KelasController::class)->except(['show']);
        Route::resource('surah', SurahController::class)->except(['show']);
        Route::resource('user', UserController::class)->except(['show']);

        Route::get('log-aktivitas', [LogAktivitasController::class, 'index'])->name('log-aktivitas.index');

        Route::get('pengaturan', [PengaturanController::class, 'edit'])->name('pengaturan.edit');
        Route::put('pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
        Route::post('pengaturan/backup', [PengaturanController::class, 'backup'])->name('pengaturan.backup');
    });
});
