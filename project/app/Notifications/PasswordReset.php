<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordReset extends ResetPasswordNotification implements ShouldQueue
{
    use Queueable;

    public function __construct($token)
    {
        parent::__construct($token);
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->view('emails.reset_password', [
                'url' => url(config('app.url') . route('password.reset', $this->token, false))
            ])
            ->subject('Redefinição de senha');
    }
}
