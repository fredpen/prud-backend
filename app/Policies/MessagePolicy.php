<?php

namespace App\Policies;

use App\Models\Investments;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    public function manage(User $user)
    {
        return $user->isBasicAdmin() ||
            $user->isSuperAdmin() ? true : false;
    }

    public function view(User $user, Investments $investments)
    {
        return $user->id === $investments->user_id;
    }
}
