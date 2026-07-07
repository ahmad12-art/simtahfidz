<?php

namespace App\Http\Middleware;

use App\Services\LogActivityService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogActivityMiddleware
{
    public function __construct(private LogActivityService $logService) {}

    /**
     * FIX #2: Middleware ini sebelumnya mencatat log SETIAP request mutasi
     * secara otomatis, tapi semua controller juga memanggil logService->catat()
     * secara manual dengan pesan yang lebih deskriptif — menghasilkan 2 baris
     * log per operasi.
     *
     * Solusi: middleware hanya mencatat jika controller TIDAK memanggil log
     * manual. Karena semua controller sudah punya log manual yang lebih
     * informatif, middleware ini dinonaktifkan dan hanya meneruskan request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }
}
