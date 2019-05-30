<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;

class ChangeEmail extends Notification
{
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = URL::temporarySignedRoute(
            'profile.security.update.email.confirm',
            Carbon::now()->addMinutes(10),
            ['id' => $notifiable->getKey()]
        );

        return (new MailMessage)
            ->subject('Solicitação de alteração de email')
            ->line('Por favor, clique no botão para alterar seu email.')
            ->action('Confirmar alterar de email', $url)
            ->line('Se você não solicitou a alteração de seu email, recomendamos que entre em contato com nossa equipe.');
    }
}
