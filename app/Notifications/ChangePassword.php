<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class ChangePassword extends Notification
{
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = URL::temporarySignedRoute(
            'profile.security.update.password.confirm',
            Carbon::now()->addMinutes(10),
            ['id' => $notifiable->getKey()]
        );

        return (new MailMessage)
            ->subject('Solicitação de alteração de senha')
            ->line('Por favor, clique no botão para alterar sua senha.')
            ->action('Confirmar alteração de senha', $url)
            ->line('Se você não solicitou a alteração de sua senha, recomendamos que entre em contato com nossa equipe.');
    }
}
