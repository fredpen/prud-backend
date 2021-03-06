<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ChatNotification extends Notification
{
    use Queueable;

    public $from;
    public $subject;
    public $body;
    public $link;
    public $sendMail;

    public function __construct(
        $subject,
        $body,
        $link,
        $from,
        $sendMail = false
    ) {
        $this->from = $from;
        $this->subject = $subject;
        $this->body = $body;
        $this->link = $link;
        $this->sendMail = $sendMail;
    }


    public function via($notifiable)
    {
        return $this->sendMail ? ['mail', 'database'] : ['database'];
    }

    public function toMail($notifiable)
    {
        return $newMessage = (new MailMessage)
            ->subject($this->subject)
            ->line($this->subject)
            ->greeting("Hi {$notifiable->first_name},")
            ->line($this->body);

        if ($this->link) {
            $newMessage->action('Visit here', $this->link);
        }

        return $newMessage->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            "intro" => "Hi {$notifiable->first_name},",
            "from" => $this->from,
            "subject" => $this->subject,
            "body" => $this->body,
            "link" => $this->link,
            "outro1" => "Best Regards,",
            "outro2" => "PEIN",
        ];
    }
}
