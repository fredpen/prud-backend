<?php

namespace App\Http\Controllers;

use App\Helpers\NotifyHelper;
use App\Helpers\ResponseHelper;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    public function send(Request $request)
    {
        try {
            $this->validateSendRequest($request);
            $this->authorize("manage", Message::class);
            $user = User::where('id', $request->user_id)->first();
            NotifyHelper::chat($user, $request->subject, $request->message);
        } catch (\Throwable $th) {
            return ResponseHelper::serverError($th->getMessage());
        }

        return ResponseHelper::sendSuccess([]);
    }

    public function usersMessages(Request $request, $id)
    {
        try {
            $this->authorize("manage", Message::class);
            return $messages = User::where('id', $id)
                ->first()
                ->notifications()
                ->where('type', 'App\\Notifications\\ChatNotification')
                ->get();
        } catch (\Throwable $th) {
            return ResponseHelper::serverError($th->getMessage());
        }

        return ResponseHelper::sendSuccess($messages);
    }

    private function validateSendRequest(Request $request)
    {
        return $request->validate([
            "user_id" => ["exists:users,id"],
            "message" => ['required', "string"],
            "subject" => ['sometimes', "string"],
        ]);
    }
}
