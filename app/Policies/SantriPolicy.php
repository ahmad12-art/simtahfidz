<?php

namespace App\Policies;

use App\Models\Santri;
use App\Models\User;

class SantriPolicy
{
    /**
     * Guru hanya dapat melihat detail santri yang berada di kelas
     * yang pernah/sedang ia bimbing (melalui transaksi setoran/murajaah/target).
     * Admin selalu diizinkan.
     */
    public function view(User $user, Santri $santri): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        $guruId = $user->guru?->id;

        return $guruId && (
            $santri->targetHafalan()->where('guru_id', $guruId)->exists()
            || $santri->setoran()->where('guru_id', $guruId)->exists()
        );
    }
}
