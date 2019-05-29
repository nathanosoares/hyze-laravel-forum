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

        $user->password = Hash::make($request->get('password'));

        $user->save();

        return redirect()
            ->route('profile.security')
            ->with('success', 'Senha alterada com sucesso!');;
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

        if ($user->hasVerifiedEmail()) {
            // TODO enviar confirmação para o email atual
        }

        if ($user->email != $request->get('email')) {
            $user->email_verified_at = null;
            $user->email = $request->get('email');

            $user->save();
        }

        return redirect()
            ->route('profile.security')
            ->with('success', 'Email alterado com sucesso!');;
    }
}
