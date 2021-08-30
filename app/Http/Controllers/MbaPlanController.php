<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Mba;
use App\Models\MbaPlan;
use Illuminate\Http\Request;

class MbaPlanController extends Controller
{
    private $updateFields = ['type', 'cost', 'numbers_of_shares_you_get', "tenure_in_months", "roi_in_percentage", "details", "start_date", "end_date", "isActive"];

    public function create(Request $request)
    {
        $this->authorize('manage', MbaPlan::class);
        $validatedData = $this->validateCreateRequest($request);

        $mba = Mba::where('id', $request->mba_id)->first();
        if (!$mba) {
            return ResponseHelper::serverError("Invalid Mba ID");
        }

        $plan = $mba->plans()->create($validatedData);

        if (!$plan) {
            return ResponseHelper::serverError("creation failed");
        }

        return ResponseHelper::sendSuccess([]);
    }


    public function update(Request $request)
    {
        $this->authorize('manage', MbaPlan::class);
        $plan = MbaPlan::where('id', $request->plan_id)->first();
        if (!$plan) {
            return ResponseHelper::serverError("Invalid plan ID");
        }

        $this->validateUpdateRequest($request, $plan);
        $plan = $plan->update($request->only($this->updateFields));

        if (!$plan) {
            return ResponseHelper::serverError("Update failed");
        }

        return ResponseHelper::sendSuccess([]);
    }

    public function delete(Request $request)
    {
        $this->authorize('manage', MbaPlan::class);
        $plan = MbaPlan::where('id', $request->id)->first();
        if (!$plan) {
            return ResponseHelper::serverError("Invalid plan ID");
        }

        if (!$plan->delete()) {
            return ResponseHelper::serverError("delete failed");
        }

        return ResponseHelper::sendSuccess([]);
    }

    private function validateUpdateRequest(Request $request, MbaPlan $plan)
    {
        return $request->validate([
            "plan_id" => ['required', "exists:mba_plan,id"],
            "type" => $plan->type == $request->type ? ["string", "sometimes"] : [
                'sometimes', "string", "unique:mba_plan"
            ],
            "cost" => ['sometimes', "numeric"],
            "numbers_of_shares_you_get" => ['sometimes', "numeric"],
            "tenure_in_months" => ['sometimes', "numeric"],
            "roi_in_percentage" => ['sometimes', "numeric"],
            "details" => ['sometimes', "string"],
            "start_date" => ['sometimes', "date"],
            "end_date" => ['sometimes', "date", "after:start_date"],
            "isActive" => ['sometimes', "boolean"],
        ]);
    }

    private function validateCreateRequest(Request $request)
    {
        return $request->validate([
            "mba_id" => ['required', "exists:mbas,id"],
            "type" => ['required', "string", "unique:mba_plan"],
            "cost" => ['required', "numeric"],
            "numbers_of_shares_you_get" => ['required', "numeric"],
            "tenure_in_months" => ['required', "numeric"],
            "roi_in_percentage" => ['required', "numeric"],
            "details" => ['sometimes', "string"],
            "start_date" => ['required', "date"],
            "end_date" => ['required', "date", "after:start_date"],
        ]);
    }
}
