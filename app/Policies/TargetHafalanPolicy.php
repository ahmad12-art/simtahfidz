<?php

namespace App\Policies;

use App\Models\TargetHafalan;
use App\Models\User;

class TargetHafalanPolicy
{
    /**
     * Admin bisa melihat/kelola semua target. Guru hanya boleh
     * mengelola target milik santri yang ia bimbing sendiri.
     */
    public function view(User $user, TargetHafalan $target): bool
    {
        return $user->isAdmin() || $target->guru?->user_id === $user->id;
    }

    public function update(User $user, TargetHafalan $target): bool
    {
        return $this->view($user, $target);
    }

    public function delete(User $user, TargetHafalan $target): bool
    {
        return $user->isAdmin() || $target->guru?->user_id === $user->id;
    }
}
