<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Str;

class UserObserver
{
    public $afterCommit = true;

    public function created(User $user)
    {
        $time = time();
        $walletRef = "{$user->id}{$time}";
        $user->wallet()->create(["walletRef" => Str::limit($walletRef, 10, '')]);
    }

    public function updated(User $user)
    {
        //
    }

    public function deleted(User $user)
    {
        //
    }

    public function restored(User $user)
    {
        //
    }

    public function forceDeleted(User $user)
    {
        //
    }
}
