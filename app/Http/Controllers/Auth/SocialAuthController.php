<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Contracts\Provider;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function callback(Request $request, $provider)
    {
        $user = $this->createOrGetUser(Socialite::driver($provider));

        auth()->login($user);

        return redirect()->to($request->session()->get('social_auth_back_url', '/'));
    }

    public function redirect(Request $request, $provider)
    {
        $request->session()->put('social_auth_back_url', url()->previous());

        return Socialite::driver($provider)->redirect();
    }

    private function createOrGetUser(Provider $provider)
    {
        $socialiteUser = $provider->user();

        $user = User::updateOrCreate(['email' => $socialiteUser->email], [
            'name' => $socialiteUser->name,
            'email' => $socialiteUser->email,
            'username' => $socialiteUser->nickname,
            'avatar' => str_replace('http://', 'https://', $socialiteUser->avatar_original)
        ]);

        return $user;
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect('/');
    }
}
