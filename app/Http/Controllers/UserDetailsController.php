<?php

namespace App\Http\Controllers;

use App\Helpers\PaystackHelper;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserDetailsController extends Controller
{
    public function getBanks()
    {
        if (Cache::has('listOfBanks')) {
             return ResponseHelper::sendSuccess(Cache::get('listOfBanks'));
        }

        $response = PaystackHelper::getBanks();
        if ($response->failed()) {
            return ResponseHelper::serverError("Could not get list of banks");
        }

        $banks = $response->collect()['data'];
        Cache::put('listOfBanks', $banks);
        return ResponseHelper::sendSuccess($banks);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $this->authorize('update', $user);

        $validatedData = $this->validateUpdateRequest($request);
        $update = $user->details()->update($validatedData);

        if (!$update) {
            return ResponseHelper::serverError("Could not update the user");
        }

        return ResponseHelper::sendSuccess([], "User updated");
    }

    private function validateUpdateRequest(Request $request)
    {
        return $request->validate([
            'bank_name' => ["sometimes", 'string', 'max:255', 'bail'],
            'sort_code' => ["sometimes", 'numeric', 'bail'],
            'account_number' => ["sometimes", 'numeric', 'bail'],
            'account_name' => ["sometimes", 'string', 'max:255', 'bail'],

            'kin_surname' => ["sometimes", 'string', 'max:255', 'bail'],
            'kin_firstname' => ["sometimes", 'string', 'bail'],
            ["sometimes", 'string', 'email:rfc,dns', 'max:255', 'bail'],
            'kin_phone' => ["sometimes", 'numeric', 'bail'],
        ]);
    }
}

