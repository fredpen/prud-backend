<?php

namespace App\Helpers;

use App\Models\User;
use Exception;

class WalletHelper
{
    public static function debitUser(User $user, float $amount): bool
    {
        if (floatval($user->wallet->balance) < $amount) {
            return throw new Exception("Insufficient balance");
        }

        return $user->wallet()->decrement('balance', $amount) ?
            true : throw new Exception("Could not charge the user");
    }

    public static function creditUser(User $user, float $amount): bool
    {
        return $user->wallet()->increment('balance', $amount) ?
            true : throw new Exception("Could not charge the user");
    }
}
