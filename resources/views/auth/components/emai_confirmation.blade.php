@if(session()->has('resent'))
<div class="alert alert-success d-flex align-items-center" role="alert">
    <div>
        <p class="text-lg">Enviamos o link de confirmação para o seu email.</p>
    </div>
</div>
@else
<div class="alert alert-warning d-flex align-items-center" role="alert">
    <div>
        <p class="text-lg">Você precisa confirmar seu e-mail.</p>
        <p>Seu email poderá ser usado para recuperar sua conta caso você se esqueça da sua senha.</p>
    </div>

    <div class="ml-auto mt-2">
        <button class="btn btn-info rounded-pill" type="button" data-toggle="modal"
            data-target="#modalEmailConfirmation">
            Enviar confirmação de email
        </button>
    </div>
</div>

<div class="modal fade" id="modalEmailConfirmation" tabindex="-1" role="dialog"
    aria-labelledby="modalEmailConfirmationTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEmailConfirmationTitle">Confirme seu email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="emailConfirmationInput">
                    Por favor, digite <code>{{ $email }}</code> para prosseguir, se este não é o seu email, clique
                    em <a href="{{ route('profile.security') }}" class="text-primary">Trocar email</a> ou feche este
                    modal para cancelar.
                </label>
                <input type="email" class="form-control rounded-pill" id="emailConfirmationInput"
                    onkeyup="checkEmail()">
            </div>
            <div class="modal-footer">
                <a href="{{ route('profile.security') }}" class="btn btn-info rounded-pill">Trocar email</a>

                {{-- <form id="logout-form" action="{{ route('verification.resend') }}" method="POST" style="display:
                none;">
                @csrf
                </form> --}}

                <a class="btn btn-primary rounded-pill disabled" href="{{ route('verification.resend') }}"
                    id="emailConfirmationButtom">
                    Enviar confirmação
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function(){
        $('#emailConfirmationInput').on("cut copy paste",function(e) {
            e.preventDefault();
        });
    });

    function checkEmail() {
        let email = "{{ $email }}";
        let input = $('#emailConfirmationInput');
        let button = $('#emailConfirmationButtom');
        
        if (input.val() === email) {
            button.removeClass("disabled");
        } else {
            button.addClass("disabled");
        }
    }
</script>
@endpush
@endif