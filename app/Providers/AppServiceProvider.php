<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        if (app()->environment() === 'production') {
            url()->forceScheme('https');
        }

        Validator::extend('allowed_email', function ($attribute, $value, $parameters, $validator) {
            $rules = [
                'email' => 'required|email',
            ];

            $data = [
                'email' => $value
            ];

            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                return false;
            }

            $domain = substr($value, strpos($value, '@') + 1);

            return in_array($domain, config('auth.allowed_email_domains', []));
        });

        // VerifyEmail::toMailUsing(function ($notifiable) {
        //     $verificationUrl = $this->verificationUrl($notifiable);

        //     return (new MailMessage)
        //         ->subject(Lang::getFromJson('Verificação de email'))
        //         ->line(Lang::getFromJson('Please click the button below to verify your email address.'))
        //         ->action(Lang::getFromJson('Verificar email'), $verificationUrl)
        //         ->line(Lang::getFromJson('If you did not create an account, no further action is required.'));
        // });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    { }
}
