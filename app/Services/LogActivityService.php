<?php

namespace App\Services;

use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

/**
 * Mencatat audit trail. Dipanggil dari middleware (otomatis untuk semua
 * request menulis data) maupun dipanggil manual dari controller untuk
 * pesan aktivitas yang lebih deskriptif (mis. "Menambahkan santri Ahmad").
 */
class LogActivityService
{
    public function catat(string $aktivitas, ?string $modul = null): void
    {
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => $aktivitas,
            'modul' => $modul,
            'ip_address' => Request::ip(),
        ]);
    }
}
