<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MbaPhotoPolicy
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
