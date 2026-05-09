<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailOtp extends Notification
{
    public function __construct(public string $code) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('🔐 Tu código de verificación - InitCode')
            ->greeting('¡Hola, ' . $notifiable->name . '!')
            ->line('Tu código de verificación es:')
            ->line('## ' . $this->code)
            ->line('Este código expira en **15 minutos**.')
            ->line('Si no creaste una cuenta en InitCode, ignora este correo.')
            ->salutation('— El equipo de InitCode');
    }
}
