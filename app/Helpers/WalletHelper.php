<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Wallet;
use Exception;

class WalletHelper
{
    public static function debitUser(User $user, float $amount)
    {
        if (floatval($user->wallet->balance) < $amount) {
            return throw new Exception("Insufficient balance");
        }

        $wallet = Wallet::find($user->wallet->id);
        return $wallet->decrement('balance', $amount) ?
            true : throw new Exception("Could not charge the user");
    }

    public static function creditUser(User $user, float $amount): bool
    {
        $wallet = Wallet::find($user->wallet->id);
        return $wallet->increment('balance', $amount) ?
            true : throw new Exception("Could not charge the user");
    }
}
