<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Helpers\WalletHelper;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function debit(Request $request)
    {
        $this->validateRequest($request);
        $this->authorize('charge', Wallet::class);

        try {
            $user = User::getUser($request->user_id);
            WalletHelper::debitUser($user->first(), floatval($request->amount));
        } catch (\Exception $e) {
            return ResponseHelper::invalidData($e->getMessage());
        }

        return ResponseHelper::sendSuccess([]);
    }

    public function credit(Request $request)
    {
        $this->authorize('charge', Wallet::class);
        $this->validateRequest($request);

        try {
            $user = User::getUser($request->user_id);
            WalletHelper::creditUser($user->first(), floatval($request->amount));
        } catch (\Exception $e) {
            return ResponseHelper::invalidData($e->getMessage());
        }

        return ResponseHelper::sendSuccess([]);
    }

    private  function validateRequest(Request $request)
    {
        return $request->validate([
            "amount" => ["required", "numeric"],
        ]);
    }
}
