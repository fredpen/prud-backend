<?php

namespace App\Helpers;

use App\Models\User;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Config;

class NotifyHelper
{

    public static function talkTo(User $user, $messageId, $xtra = false)
    {
        $messageData = Self::setMessage($messageId, $xtra);

        $from = array_key_exists("from", $messageData) ? $messageData['from'] : "3HJOBS Support";
        $link = array_key_exists("link", $messageData) ? $messageData['link'] : false;
        $subject = array_key_exists("subject", $messageData) ? $messageData['subject'] : "Message from 3HJOBS Support";
        $body = array_key_exists("body", $messageData) ? $messageData['body'] : "Thanks for using our services";
        $sendMail = !!$messageData['sendMail'];

        $user->notify(new GeneralNotification($subject, $body, $link, $from, $sendMail));
    }

    private static function setMessage($messageId, $xtra)
    {
        $appName = Config::get('app.name');
        if ($messageId == "account_creation") {

            return  [
                "subject" => "Account Update",
                "body" => "Welcome to {$appName}. Your temporary password is {$xtra}",
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
