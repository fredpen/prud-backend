<?php

namespace App\Http\Controllers;

use App\Helpers\NotifyHelper;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function setSecurity(Request $request)
    {
        $request->validate([
            'security_question' => 'bail|required|string|min:4',
            'security_answer' => 'bail|required|string|min:4'
        ]);

        $user = $request->user();
        if ($user->security_question) {
            return ResponseHelper::badRequest("Security question has already been set, you can only set this once");
        }

        $update = $user->update($request->only(['security_question', 'security_answer']));

        return $update ? ResponseHelper::sendSuccess([], "security question set") : ResponseHelper::serverError();
    }

    public function userDetails(Request $request)
    {
        return ResponseHelper::sendSuccess($request
            ->user()->with(['details', 'wallet'])->first());
    }

    public function updateUser(Request $request)
    {
         $validatedData = $this->sanitizeRequest($request, $request->user());

        if ($request->has('avatar')) {
            $url =  $request->user()
                ->storeMyFile($request->file('avatar'), 'avatars', $request->user()->id);
            $validatedData['avatar'] = $url;
        }

        $update = $request->user()->update($validatedData);
        if (!$update) {
            return ResponseHelper::serverError();
        }

        NotifyHelper::talkTo($request->user(),  "account_update");
        return ResponseHelper::sendSuccess([], "Update successful");
    }

    public function updateSecurityData(Request $request)
    {
        $validatedData = $this->sanitizeRequest($request, $request->user());

        $user = $request->user()->makeVisible(['security_answer']);
        if ($user->security_answer != $request->security_answer) {
            return ResponseHelper::badRequest("Incorrect security answer");
        }

        unset($validatedData['security_answer']);
        $update = $user->update($validatedData);
        if (!$update) {
            return ResponseHelper::serverError();
        }

        NotifyHelper::talkTo($request->user(),  "account_update");
        return ResponseHelper::sendSuccess([], "Update successful");
    }

    private function sanitizeRequest($request, $user)
    {
        return $request->validate([
            'surname' => ['sometimes', 'string', 'max:255'],
            'first_name' => ['sometimes', 'string', 'max:255'],
            'title' => ['sometimes', 'string', 'max:255'],
            'address' => ['sometimes', 'string', 'max:255'],
            'email' => $user->email == $request->email ? []
                : ['sometimes', 'string', 'email:rfc,dns', 'max:255', 'unique:users'],
            'phone_number' => $user->phone_number == $request->phone_number ? []
                : ['sometimes', 'string', 'max:255', 'unique:users'],
        ]);
    }
}
