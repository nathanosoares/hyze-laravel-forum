<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class SecurityController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('signed')->only('updatePasswordConfirm');
    }

    public function index()
    {
        return view('profile.security');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $this->validate($request, [
            'now_password' => [
                'required',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail($attribute . ' is invalid.');
                    }
                }
            ],
            'password' => 'required|confirmed|different:now_password',
        ]);


        $newHashedPassword = Hash::make($request->get('password'));

        if ($user->hasVerifiedEmail()) {

            $request->session()->put('new_hashed_password', $newHashedPassword);

            $user->sendChangePasswordNotification();

            return redirect()
                ->route('profile.security')
                ->with('info', 'Você possui um email confirmado em sua conta, então um email de confirmação foi enviado para ' . $user->email);
        }

        $user->password = $newHashedPassword;

        $user->save();

        return redirect()
            ->route('profile.security')
            ->with('success', 'Senha alterada com sucesso!');
    }

    public function updateEmail(Request $request)
    {
        $user = auth()->user();

        $this->validate($request, [
            'email' => [
                'required',
                'allowed_email',
                'confirmed',
                Rule::unique('hyze.users', 'email')->ignore($user->id)
            ]
        ]);

        if ($user->is_banned_permanently) {
            return redirect()
                ->route('profile.security')
                ->with('error', 'Você não pode mudar o email!');
        }

        if ($user->email != $request->get('email')) {

            $newEmail = $request->get('email');

            if ($user->hasVerifiedEmail()) {
                $request->session()->put('new_email', $newEmail);

                $user->sendChangeEmailNotification();

                return redirect()
                    ->route('profile.security')
                    ->with('info', 'Você possui um email confirmado em sua conta, então um email de confirmação foi enviado para ' . $user->email);
            }


            $user->email_verified_at = null;
            $user->email = $newEmail;

            $user->save();
        }

        return redirect()
            ->route('profile.security')
            ->with('success', 'Email alterado com sucesso!');
    }

    public function updateEmailConfirm(Request $request)
    {
        if (!$request->session()->has('new_email')) {
            return redirect()
                ->route('profile.security')
                ->with('error', 'Algo de errado aconteceu! Tente novamente.');;
        }

        $newEmail = $request->session()->pull('new_email');

        $user = auth()->user();

        $user->email_verified_at = null;
        $user->email = $newEmail;

        $user->save();

        return redirect()
            ->route('profile.security')
            ->with('success', 'Email alterado com sucesso!');
    }

    public function updatePasswordConfirm(Request $request)
    {
        if (!$request->session()->has('new_hashed_password')) {
            return redirect()
                ->route('profile.security')
                ->with('error', 'Algo de errado aconteceu! Tente novamente.');;
        }

        $newHashedPassword = $request->session()->pull('new_hashed_password');

        $user = auth()->user();

        $user->password = $newHashedPassword;

        $user->save();

        return redirect()
            ->route('profile.security')
            ->with('success', 'Senha alterada com sucesso!');
    }
}
