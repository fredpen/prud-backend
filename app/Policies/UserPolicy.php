<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return false;
    }

    public function update(User $user)
    {
        return false;
    }
}
