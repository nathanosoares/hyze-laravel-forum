@extends('layouts.forum')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5 col-sm-8">
        <div class="bg-white shadow-sm rounded py-4 px-4">
            <form method="POST" action="{{ route('login') }}" id="login">
                @csrf

                <div class="form-group">
                    <label for="nick" class="text-md-right">
                        Nick utilizado no servidor:
                    </label>

                    <input id="nick" type="text" class="form-control {{ $errors->has('nick') ? ' is-invalid' : '' }}"
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
                        class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                        required>

                    @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group ">
                    <div class="">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>

                            <label class="custom-control-label" for="remember">
                                Continuar logado
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <div class="">

                        <button class="g-recaptcha btn btn-primary btn rounded-pill" data-callback="onSubmitlogin"
                            data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}">
                            Entrar
                        </button>

                        @if ($errors->has('g-recaptcha-response'))
                        <span class="help-block">
                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                        </span>
                        @endif

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
@endsection

@push('scripts')
<script>
    function onSubmitlogin() {
        document.getElementById("login").submit();
    }
</script>
@endpush