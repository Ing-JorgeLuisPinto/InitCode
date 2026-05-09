<?php
namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends VerifyEmail
{
    protected function buildMailMessage($url): MailMessage
    {
        return (new MailMessage)
            ->subject('✅ Verifica tu cuenta en InitCode')
            ->greeting('¡Hola!')
            ->line('Gracias por registrarte en InitCode. Haz clic en el botón para verificar tu correo.')
            ->action('Verificar mi correo', $url)
            ->line('Este enlace expirará en 60 minutos.')
            ->line('Si no creaste una cuenta en InitCode, ignora este correo.')
            ->salutation('— El equipo de InitCode');
    }
}
