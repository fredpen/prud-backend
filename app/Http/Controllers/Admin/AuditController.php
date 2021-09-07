<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;

class AuditController extends Controller
{
    public function walletAudit(Request $request)
    {
        $wallet = Wallet::where('id', $request->id)->first();

        if (!$wallet) {
            return ResponseHelper::notFound();
        }

        return $wallet->audits ?
            ResponseHelper::sendSuccess($wallet->audits) : ResponseHelper::notFound("no audit");
    }

    public function userAudit(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();

        if (!$user) {
            return ResponseHelper::notFound();
        }

        return $user->audits->count() ?
            ResponseHelper::sendSuccess($user->audits) : ResponseHelper::notFound("no audit");
    }
}
