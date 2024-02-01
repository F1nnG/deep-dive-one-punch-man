<?php

namespace App\Policies;

use App\Models\Battle;
use App\Models\User;

class BattlePolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Battle $battle): bool
    {
        return $battle->is_finished;
    }

    public function create(?User $user): bool
    {
        return false;
    }

    public function update(?User $user, Battle $battle): bool
    {
        return false;
    }

    public function delete(?User $user, Battle $battle): bool
    {
        return false;
    }
}
