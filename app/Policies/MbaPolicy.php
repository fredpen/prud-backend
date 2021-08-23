<?php

namespace App\Policies;

use App\Models\Mba;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MbaPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    public function create(User $user)
    {
        return $user->isBasicAdmin() ? true : false;
    }
}
