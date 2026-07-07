<?php

namespace App\Policies;

use App\Models\Setoran;
use App\Models\User;

class SetoranPolicy
{
    public function update(User $user, Setoran $setoran): bool
    {
        return $user->isAdmin() || $setoran->guru?->user_id === $user->id;
    }

    public function delete(User $user, Setoran $setoran): bool
    {
        return $user->isAdmin() || $setoran->guru?->user_id === $user->id;
    }
}
