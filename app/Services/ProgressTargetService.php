<?php

namespace App\Services;

use App\Models\TargetHafalan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Mengurus pembaruan progress Target Hafalan setiap kali ada Setoran baru
 * yang terhubung ke target tersebut. Dipisah dari SetoranController agar
 * logikanya reusable (misalnya dipanggil ulang dari job/command recalculate).
 */
class ProgressTargetService
{
    public function updateFromSetoran(?TargetHafalan $target): void
    {
        if (! $target) {
            return;
        }

        $totalAyatTarget = max(1, ($target->ayat_akhir - $target->ayat_awal) + 1);

        $ayatTercapai = (int) $target->setoran()
            ->where('status', 'lancar')
            ->sum(DB::raw('(ayat_akhir - ayat_awal + 1)'));

        $progress = min($ayatTercapai, $totalAyatTarget);

        $persentase = round(($progress / $totalAyatTarget) * 100, 2);
        $persentase = min(100, max(0, $persentase));

        $status = 'berjalan';
        if ($persentase >= 100) {
            $status = 'selesai';
        } elseif ($target->deadline && Carbon::parse($target->deadline)->isPast()) {
            $status = 'terlambat';
        }

        $target->update([
            'persentase_progress' => $persentase,
            'status' => $status,
        ]);
    }
}
