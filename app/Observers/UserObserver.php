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

        $user->details()->create();
    }
}
