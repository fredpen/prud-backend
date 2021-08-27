<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Constant;
use App\Helpers\NotifyHelper;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function show(Request $request)
    {
        if ($request->id == 1) abort(403, "Insufficient permission");
        $this->authorize('viewAny', User::class);

       $user = User::where('id', $request->id);
        return $user ?
            ResponseHelper::sendSuccess($user->with(['details', 'wallet'])->get()) : ResponseHelper::notFound("Invalid user Id");
    }

    public function all()
    {
        $this ->authorize('viewAny', User::class);

        $users = User::query();

        return $users->count() ?
            ResponseHelper::sendSuccess($users
                ->orderBy('updated_at', 'desc')
                ->paginate(Constant::PERPAGE)) : ResponseHelper::notFound();
    }

    public function create(Request $request)
    {
        $this->authorize('update', User::class);

        $request->validate([
            'first_name' => ['required', 'string', 'max:255', 'bail'],
            'surname' => ['required', 'string', 'max:255', 'bail'],
            'phone_number' => ['required', 'numeric', "unique:users", 'bail'],
            'role_id' => ['numeric', 'min:2', 'max:4'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users', 'bail'],
        ]);

        $password = time();
        $input = $request->all();
        $input['password'] = bcrypt($password);
        $input['created_by'] = $request->user()->id;
        $user = User::create($input);

        if (!$user) {
            return ResponseHelper::serverError();
        }

        $success['default_password'] = $password;

        NotifyHelper::talkTo($user,  "account_creation", $password);
        return ResponseHelper::sendSuccess($success, "User created");
    }

    public function update(Request $request)
    {
        if ($request->id == 1) abort(403, "Insufficient permission");
        $user = User::where('id', $request->id)->first();
        if (!$user) {
            return ResponseHelper::serverError("Invalid User Id");
        }

        $this->authorize('update', $user);
        $validatedData = $this->validateUpdateRequest($request, $user);

        unset($validatedData['id']);
        $validatedData['password'] = bcrypt($request->password);
        $update = $user->update($validatedData);

        if (!$update) {
            return ResponseHelper::serverError("Could not update the user");
        }

        return ResponseHelper::sendSuccess([], "User updated");
    }

    public function delete(Request $request)
    {
        if ($request->id == 1) abort(403, "Insufficient permission");
        $user = User::where('id', $request->id)->first();
        if (!$user) {
            return ResponseHelper::serverError("Invalid User Id");
        }
        $this->authorize('update', $user);

        $delete = $user->delete();

        if (!$delete) {
            return ResponseHelper::serverError("Could not delete the user");
        }

        return ResponseHelper::sendSuccess([], "User deleted");
    }


    private function validateUpdateRequest(Request $request, User $user)
    {
        return $request->validate([
            "id" => ["required", "exists:users,id"],
            'first_name' => ["sometimes", 'string', 'max:255', 'bail'],
            'surname' => ["sometimes", 'string', 'max:255', 'bail'],
            'address' => ["sometimes", 'string', 'max:255', 'bail'],
            'phone_number' => ["sometimes", 'numeric', "unique:users", 'bail'],
            'role_id' => ["sometimes", 'numeric', 'min:2', 'max:4'],
            "isActive" => ['sometimes', 'boolean'],
            'email' => $request->email != $user->email ? ["sometimes", 'string', 'email:rfc,dns', 'max:255', 'unique:users', 'bail'] : ["nullable"],
            'phone_number' => $request->phone_number != $user->phone_number ? ["sometimes", 'numeric', "unique:users", 'bail'] : ["nullable"],
            'password' => ["sometimes", 'string', "min:6", "max:20"],
        ]);
    }
}
