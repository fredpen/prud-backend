<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Helpers\WalletHelper;
use App\Models\User;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function debit(Request $request)
    {
        $this->validateRequest($request);
        $this->authorize('update', $request->user());

        try {
            $user = User::where('id', $request->user_id)->first();
            WalletHelper::debitUser($user, floatval($request->amount));
        } catch (\Exception $e) {
            return ResponseHelper::invalidData($e->getMessage());
        }

        return ResponseHelper::sendSuccess([]);
    }

    public function credit(Request $request)
    {
        $this->authorize('update', $request->user());
        $this->validateRequest($request);

        try {
            $user = User::where('id', $request->user_id)->first();
            WalletHelper::creditUser($user, floatval($request->amount));
        } catch (\Exception $e) {
            return ResponseHelper::invalidData($e->getMessage());
        }

        return ResponseHelper::sendSuccess([]);
    }

    private  function validateRequest(Request $request)
    {
        return $request->validate([
            "amount" => ["required", "numeric"],
            "user_id" => ["required", "exists:users,id"],
        ]);
    }
}
