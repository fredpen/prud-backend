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
    public function all()
    {
        $this->authorize('viewAny', User::class);

        $users = User::query();

        return $users->count() ?
            ResponseHelper::sendSuccess($users
                ->orderBy('updated_at', 'desc')
                ->paginate(Constant::PERPAGE)) : ResponseHelper::notFound();
    }

    public function create(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $request->validate([
            'first_name' => ['required', 'string', 'max:255', 'bail'],
            'surname' => ['required', 'string', 'max:255', 'bail'],
            'phone_number' => ['required', 'string', 'max:255', "unique:users", 'bail'],
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
}
