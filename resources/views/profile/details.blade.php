@extends('profile.layout')

@section('profile.content')
<div class="shadow-sm rounded bg-white p-4">
    <h3>Grupos no servidor</h3>
    @if(count(auth()->user()->groups_due))
    <table class="table table-borderless">
        <thead>
            <tr>
                <th scope="col">Grupo</th>
                <th scope="col">Validade</th>
            </tr>
        </thead>
        <tbody>
            @foreach (auth()->user()->groups_due as $group)
            <tr>
                <td>{{ $group->display_name }}</td>
                <td>
                    @if(is_null($group->due_at))
                    Permanente
                    @else
                    {{ $group->due_at->format('d M Y') }}
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="text-center">
        <p class="text-lg mt-4">
            Você não possui nenhum grupo em nossos servidores.
        </p>

        <a class="btn btn-primary btn-lg rounded-pill" href="https://loja.hyze.net/" target="_black">
            <i class="fa fa-star"></i> Ir para loja
        </a>
    </div>
    @endif
</div>
@endsection
