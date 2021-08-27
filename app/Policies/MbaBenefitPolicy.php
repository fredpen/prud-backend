<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MbaBenefitPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->isBasicAdmin() ||
            $user->isSuperAdmin() ? true : false;
    }
}
