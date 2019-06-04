@extends('layouts.forum')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5 col-sm-8">
        <div class="bg-white shadow-sm rounded py-4 px-4">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="text-md-right">Email</label>

                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                        name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary btn rounded-pill">
                        Enviar o link de redefinição de senha
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection