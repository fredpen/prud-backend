<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Constant;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\InvestmentsController as UsersInvestmentsController;
use App\Models\Investments;
use App\Models\User;
use Illuminate\Http\Request;

class InvestmentsController extends Controller
{
    public function usersInvestments($id)
    {
        try {
            $this->authorize('manage', Investments::class);
            $user = User::findOrFail($id);
            $investments = $user->investments;
        } catch (\Throwable $th) {
            return ResponseHelper::notFound($th->getMessage());
        }

        return ResponseHelper::sendSuccess($investments);
    }

    public function allInvestments()
    {
        try {
            $this->authorize('manage', Investments::class);
            $investments = Investments::paginate(Constant::PERPAGE);
        } catch (\Throwable $th) {
            return ResponseHelper::notFound($th->getMessage());
        }

        return ResponseHelper::sendSuccess($investments);
    }

    public function show($id)
    {
        try {
            $this->authorize('manage', Investments::class);
            $investment = Investments::findOrFail($id);
        } catch (\Throwable $th) {
            return ResponseHelper::notFound($th->getMessage());
        }

        return ResponseHelper::sendSuccess($investment);
    }

    public function create(Request $request)
    {
        try {
            $this->authorize('manage', Investments::class);
            $this->validateRequest($request);
            $user = User::findOrFail($request->user_id);
            UsersInvestmentsController::createInvestment($user, $request->plan_id);
        } catch (\Throwable $th) {
            return ResponseHelper::notFound($th->getMessage());
        }

        return ResponseHelper::sendSuccess([]);
    }

    public function update(Request $request, $id)
    {
        try {
            $this->authorize('manage', Investments::class);
            $investment = Investments::findOrFail($id);
            if ($request->status) {
                $updateData = $this->updateData($request->status);
                $investment->update($updateData);
            }
        } catch (\Throwable $th) {
            return ResponseHelper::notFound($th->getMessage());
        }

        return ResponseHelper::sendSuccess([]);
    }

    public function updateData($status)
    {
        return [
            "payment_status" => $status,
            "payment_description" => Investments::describeKey($status),
            Investments::getFieldToUpdate($status) => now()
        ];
    }

    private  function validateRequest(Request $request)
    {
        return $request->validate([
            "plan_id" => ["required", "exists:mba_plan,id"]
        ]);
    }
}
