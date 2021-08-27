<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class WalletPolicy
{
    use HandlesAuthorization;

    public function charge(User $user)
    {
        return $user->isBasicAdmin() ||
            $user->isSuperAdmin() ? true : false;
    }
}
