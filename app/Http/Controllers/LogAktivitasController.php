<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $log = LogAktivitas::query()
            ->with('user')
            ->when($request->user_id, fn ($q) => $q->where('user_id', $request->user_id))
            ->when($request->modul, fn ($q) => $q->where('modul', $request->modul))
            ->when($request->tanggal, fn ($q) => $q->whereDate('created_at', $request->tanggal))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $modulList = LogAktivitas::select('modul')->distinct()->pluck('modul');

        return view('log-aktivitas.index', compact('log', 'modulList'));
    }
}
