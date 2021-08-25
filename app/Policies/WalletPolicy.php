<?php

namespace App\Policies;

use App\Models\User;
use App\Models\odel=Wallet;
use Illuminate\Auth\Access\HandlesAuthorization;

class WalletPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\odel=Wallet  $odel=Wallet
     * @return mixed
     */
    public function view(User $user, odel=Wallet $odel=Wallet)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\odel=Wallet  $odel=Wallet
     * @return mixed
     */
    public function update(User $user, odel=Wallet $odel=Wallet)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\odel=Wallet  $odel=Wallet
     * @return mixed
     */
    public function delete(User $user, odel=Wallet $odel=Wallet)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\odel=Wallet  $odel=Wallet
     * @return mixed
     */
    public function restore(User $user, odel=Wallet $odel=Wallet)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\odel=Wallet  $odel=Wallet
     * @return mixed
     */
    public function forceDelete(User $user, odel=Wallet $odel=Wallet)
    {
        //
    }
}
