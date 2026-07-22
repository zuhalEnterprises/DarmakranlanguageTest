<?php
namespace App\Notifications;
use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class CustomVerifyEmail extends BaseVerifyEmail
{
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('تأیید ایمیل شما')
            ->greeting('سلام عزیز!')
            ->line('برای فعال‌سازی حساب کاربری، لطفاً روی دکمه زیر کلیک کنید.')
            ->action('تأیید ایمیل', $verificationUrl)
            ->line('اگر شما ثبت‌نام نکرده‌اید، این پیام را نادیده بگیرید.')
            ->salutation('با احترام، تیم ما');
    }

    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
        );
    }
}
