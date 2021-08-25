<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mba;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class MbaController extends Controller
{
    private $with = ['photos', 'benefits:id,body,mba_id'];

    public function getAllMbas()
    {
        if (Cache::has('listOfMbas')) {
            return ResponseHelper::sendSuccess(Cache::get('listOfMbas'));
        }

        $mbas = Mba::query();
        if (!$mbas->count()) {
            return ResponseHelper::notFound("No Mba available");
        }

        $mbas = $mbas->with($this->with)->get(['id', 'name', 'status']);
        Cache::put('listOfMbas', $mbas);
        return ResponseHelper::sendSuccess($mbas);
    }

    public function getActiveMbas()
    {
        if (Cache::has('listOfActiveMbas')) {
            return ResponseHelper::sendSuccess(Cache::get('listOfActiveMbas'));
        }

        $mbas = Mba::where('status', true);
        if (!$mbas->count()) {
            return  ResponseHelper::notFound("No Mba available");
        }

        $mbas = $mbas->with($this->with)->get(['id', 'name', 'status']);
        Cache::put('listOfActiveMbas', $mbas);
        return ResponseHelper::sendSuccess($mbas);
    }

    public function show(Request $request)
    {
        $mba = Mba::where('id', $request->id);
        if (!$mba->count()) {
            return ResponseHelper::notFound("Invalid Mba Id");
        }

        $mba = $mba->with($this->with)
            ->first(['id', 'name', 'status']);

        return ResponseHelper::sendSuccess($mba);
    }

    public function create(Request $request)
    {
        $this->authorize('create', $request->user());
        $this->validateCreateRequest($request);

        $mba = Mba::create($request->only('name'));
        if (!$mba) {
            return ResponseHelper::serverError("creation failed");
        }

        return ResponseHelper::sendSuccess($mba);
    }

    public function update(Request $request)
    {
        $this->authorize('create', $request->user());
        $mba = Mba::where('id', $request->id)->first();
        if (!$mba) {
            return ResponseHelper::notFound("Invalid Mba Id");
        }

        $this->validateUpdateRequest($request, $mba);

        $update = $mba->update($request->only(['name', 'status']));
        if (!$update) {
            return  ResponseHelper::serverError("creation failed");
        }

        return ResponseHelper::sendSuccess([]);
    }

    public function delete(Request $request)
    {
        $this->authorize('create', $request->user());
        $mba = Mba::where('id', $request->id)->first();

        if (!$mba) {
            return ResponseHelper::notFound("Invalid Mba Id");
        }

        if ($mba->delete()) {
            return ResponseHelper::sendSuccess([]);
        }

        return ResponseHelper::serverError();
    }

    private function validateCreateRequest(Request $request)
    {
        return $request->validate([
            "name" => ['required', "unique:mbas,name"]
        ]);
    }

    private function validateUpdateRequest(Request $request, Mba $mba)
    {
        return $request->validate([
            "name" => $request->name == $mba->name ? ["required"] : ['required', "unique:mbas,name"],
            "status" => ["sometimes", "boolean"]
        ]);
    }
}
