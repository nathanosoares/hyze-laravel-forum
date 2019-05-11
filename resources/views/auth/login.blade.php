@extends('layouts.chatter')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="">
                <div class="">
                    <div class="bg-ghost py-3 px-4">
                        <form method="POST" action="{{ route('login') }}" id="login">
                            @csrf

                            <div class="form-group">
                                <label for="nick" class="text-md-right">
                                    Nick utilizado no servidor:
                                </label>

                                <input id="nick" type="text"
                                       class="form-control {{ $errors->has('nick') ? ' is-invalid' : '' }}"
                                       name="nick" value="{{ old('nick') }}" required autofocus>

                                @if ($errors->has('nick'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nick') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="password" class="text-md-right">
                                    Senha utilizada no servidor:
                                </label>

                                <input id="password" type="password"
                                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                       name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            {!! NoCaptcha::displaySubmit('login', 'submit now!', ['class' => 'btn btn-primary']) !!}
                            @if ($errors->has('g-recaptcha-response'))
                            <span class="help-block">
                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                            </span>
                            @endif

                            <div class="form-group ">
                                <div class="">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember"
                                               id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-0">
                                <div class="">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
