<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MbaPlanPolicy
{
    use HandlesAuthorization;

    public function manage(User $user)
    {
        return $user->isBasicAdmin() ||
            $user->isSuperAdmin() ? true : false;
    }
}
