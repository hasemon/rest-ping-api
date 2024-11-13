<?php

namespace App\Notifications;

use App\Models\Check;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CheckFailed extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly Check $check
    )
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("FAILED: Your check for {$this->check->name} has failed.")
                    ->line('Service checked: Service is down!')
                    ->line('Thank you for using our application!');
    }


    public function toArray(object $notifiable): array
    {
        return [
            'check' => $this->check->id,
            'message' => "Your check for {$this->check->name} has failed."
        ];
    }
}
