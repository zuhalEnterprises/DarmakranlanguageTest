<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class CustomResetPassword extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('بازیابی رمز عبور')
            ->greeting('سلام!')
            ->line('شما این ایمیل را دریافت کردید چون درخواست بازیابی رمز عبور دادید.')
            ->action('بازیابی رمز عبور', $url)
            ->line('این لینک تا 60 دقیقه اعتبار دارد.')
            ->line('اگر شما درخواست بازیابی نداده‌اید، این پیام را نادیده بگیرید.')
            ->salutation('با احترام، تیم پشتیبانی');
    }
}
