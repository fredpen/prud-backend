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
    }

    public function viewAny(User $user)
    {
        return $user->isBasicUser() ? false : true;
    }

    public function view(User $user, User $model)
    {
        if ($user->id == 1) {
            return false;
        }

        return $user->isBasicUser() ? false : true;
    }

    public function create(User $user)
    {
        return $user->isBasicAdmin() ? true : false;
    }

    public function update(User $user, User $model)
    {
        if ($user->id == $model->id) {
            return true;
        }

        if ($model->id == 1) {
            return false;
        }

        return $user->isBasicAdmin() ? true : false;
    }

    public function delete(User $user, User $model)
    {
        if ($model->id == 1) {
            return false;
        }

        return $user->isBasicAdmin() ? true : false;
    }


    public function restore(User $user, User $model)
    {
        return $user->isBasicAdmin() ? true : false;
    }

    public function forceDelete(User $user, User $model)
    {
        if ($model->id == 1) {
            return false;
        }

        return $user->isBasicAdmin() ? true : false;
    }
}
