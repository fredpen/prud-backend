<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Mba;
use App\Models\MbaBenefits;
use Illuminate\Http\Request;

class MbaBenefitsController extends Controller
{

    public function create(Request $request)
    {
        $this->authorize('create', MbaBenefits::class);
        $this->validateCreateRequest($request);

        $mba = Mba::where('id', $request->mba_id)->first();
        $benefit = $mba->benefits()->create($request->only('body'));

        if (!$benefit) {
            return ResponseHelper::serverError("creation failed");
        }

        return ResponseHelper::sendSuccess([]);
    }

    public function update(Request $request)
    {
        $this->authorize('create', MbaBenefits::class);
        $this->validateUpdateRequest($request);

        $benefit = MbaBenefits::where('id', $request->id)->first();
        $benefit = $benefit->update($request->only('body'));

        if (!$benefit) {
            return ResponseHelper::serverError();
        }

        return ResponseHelper::sendSuccess([]);
    }

    public function delete(Request $request)
    {
        $this->authorize('create', MbaBenefits::class);
        $request->validate(["id" => ['required', "exists:mba_benefits,id"]]);

        $benefit = MbaBenefits::where('id', $request->id)->first();
        $benefit = $benefit->delete();

        if (!$benefit) {
            return ResponseHelper::serverError();
        }

        return ResponseHelper::sendSuccess([]);
    }

    private function validateCreateRequest(Request $request)
    {
        return $request->validate([
            "body" => ['required', "string", "unique:mba_benefits,body"],
            "mba_id" => ['required', "exists:mbas,id"],
        ]);
    }

    private function validateUpdateRequest(Request $request)
    {
        return $request->validate([
            "body" => ['required', "string"],
            "id" => ['required', "exists:mba_benefits,id"],
        ]);
    }
}
