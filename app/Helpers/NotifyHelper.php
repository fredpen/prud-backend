<?php

namespace App\Helpers;

use App\Models\User;
use App\Notifications\ChatNotification;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Config;

class NotifyHelper
{
    public static function chat(User $user, $subject, $body)
    {
        $from = "PEIN-ADMIN";
        $user->notify(new ChatNotification($subject, $body, false, $from, true));
    }

    public static function talkTo(User $user, $messageId, $xtra = false)
    {
        $messageData = Self::setMessage($messageId, $xtra);

        $from = array_key_exists("from", $messageData) ? $messageData['from'] : "PEIN";
        $link = array_key_exists("link", $messageData) ? $messageData['link'] : false;
        $subject = array_key_exists("subject", $messageData) ? $messageData['subject'] : "Message from PEIN";
        $body = array_key_exists("body", $messageData) ? $messageData['body'] : "Thanks for using our services";
        $sendMail = !!$messageData['sendMail'];

        $user->notify(new GeneralNotification($subject, $body, $link, $from, $sendMail));
    }

    private static function setMessage($messageId, $xtra)
    {
        $appName = Config::get('app.name');

        if ($messageId == "account_creation") {
            return  [
                "subject" => "Account Creation",
                "body" => $xtra ? "Welcome to {$appName}. Your temporary password is {$xtra}" : "Welcome to {$appName}",
                "sendMail" => true
            ];
        }

        if ($messageId == "login") {
            return  [
                "subject" => "Login Notification",
                "body" => "Login action",
                "sendMail" => false
            ];
        }

        return [
            "title" => "Account Update",
            "subject" => "This is to notify you that an update has been on your account",
            "sendMail" => false
        ];
    }
}
