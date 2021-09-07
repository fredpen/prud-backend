<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Investments;
use App\Models\Mba;
use App\Models\MbaPlan;
use App\Models\User;
use Illuminate\Http\Request;

class InvestmentsController extends Controller
{
    public function myInvestments(Request $request)
    {
        $investments = $request->user()->investments;
        return $investments ?  ResponseHelper::sendSuccess($investments) : ResponseHelper::notFound();
    }

    public function create(Request $request)
    {
        $this->validateRequest($request);
        $create = self::createInvestment($request->user(), $request->plan_id);

        return $create ? ResponseHelper::sendSuccess([]) : ResponseHelper::serverError();
    }

    public function show($id)
    {
        $investment = Investments::where('id', $id)->first();
        if (!$investment) {
            return ResponseHelper::notFound("Invalid investment Id");
        }

        $this->authorize('view', $investment);
        return ResponseHelper::sendSuccess($investment);
    }

    private  function validateRequest(Request $request)
    {
        return $request->validate([
            "plan_id" => ["required", "exists:mba_plan,id"]
        ]);
    }

    public static function createInvestment(User $user, int $plan_id)
    {
        $mbaPlan = MbaPlan::where('id', $plan_id)->with(['mba'])->first();

        return $user->investments()->create([
            "mba_id" => $mbaPlan->mba->id,
            "plan_id" => $mbaPlan->id,
            "num_of_units" => $mbaPlan->numbers_of_shares_you_get,
            "plan_name" => $mbaPlan->type,
            "tenure_in_months" => $mbaPlan->tenure_in_months,
            "roi_in_percentage" => $mbaPlan->roi_in_percentage,
            "amount_paid" => $mbaPlan->cost,
            "payment_description" => Investments::describeKey(1),
        ]);
    }
}
