@extends('profile.layout')

@section('profile.content')

@if(session()->has('success'))
<div class="alert alert-success">
    {{ session()->get('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="shadow-sm rounded bg-white p-4">

    @if(auth()->user()->email)
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Email atual</label>
        <div class="col-sm-10 d-flex flex-column">
            <input type="text" class="form-control rounded-pill" value="{{ auth()->user()->email }}"
                aria-describedby="emailHelpBlock" disabled>

            <small id="emailHelpBlock" class="form-text text-muted">
                Seu email poderá ser usado para recuperar sua conta caso você se esqueça da sua senha.
            </small>
        </div>
    </div>

    <hr>

    @endif

    <form action="{{ route('profile.security.update.email') }}" method="POST" class="d-flex flex-column">
        @csrf
        @method('PUT')
        <div class="form-group row">
            <label for="newEmailLabel" class="col-sm-2 col-form-label">Definir email</label>
            <div class="col-sm-10">
                <input type="email" class="form-control rounded-pill @error('email') is-invalid @enderror"
                    id="newEmailLabel" name="email" value="{{ old('email') }}" placeholder="Digite o novo email"
                    required>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10">
                <input type="email" class="form-control rounded-pill" name="email_confirmation"
                    placeholder="Confirme o novo email" required>
            </div>
        </div>

        <button class="btn btn-primary btn-sm ml-auto rounded-pill">
            Definir Email
        </button>
    </form>

    <hr>

    <form action="{{ route('profile.security.update.password') }}" method="POST" class="d-flex flex-column">
        @csrf
        @method('PUT')

        <div class="form-group row">
            <label for="currentPasswordLabel" class="col-sm-2 col-form-label">Definir senha</label>
            <div class="col-sm-10">
                <input type="password" class="form-control rounded-pill @error('now_password') is-invalid @enderror"
                    id="currentPasswordLabel" placeholder="Digite sua senha atual" name="now_password">
                @error('now_password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('now_password') }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="newPasswordLabel" class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10">
                <input type="password" class="form-control rounded-pill @error('password') is-invalid @enderror"
                    id="newPasswordLabel" placeholder="Digite a nova senha" name="password" autocomplete="new-password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <span class="col-sm-2 col-form-label"></span>
            <div class="col-sm-10">
                <input type="password" class="form-control rounded-pill" id="colFormLabel" name="password_confirmation"
                    placeholder="Confirme a nova senha">
            </div>
        </div>

        <button class="btn btn-primary btn-sm ml-auto rounded-pill">
            Definir Senha
        </button>
    </form>
</div>
@endsection