@extends('layouts.admin')

@section('content')

<div>
    {{ dump($errors) }}
    <h2 class="mb-4">Editando forum {{ $forum->name }} <span class="text-muted">({{ $forum->id }})</span></h2>

    <form class="d-flex flex-column" action="{{ route('admin.forums.update', $forum) }}" method="POST">
        @method('PUT')
        @csrf
        <div class="form-group row">
            <label for="inputName" class="col-sm-2 col-form-label">Nome</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputName" placeholder="Nome" name="name"
                    value="{{ old('name', $forum->name) }}" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputSlug" class="col-sm-2 col-form-label">Slug</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputSlug" placeholder="Slug" name="slug"
                    value="{{ old('slug', $forum->slug) }}" required>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputRestrictRead" class="col-sm-2 col-form-label">Quem pode ler?</label>
            <div class="col-sm-10">
                <select class="custom-select" name="restrict_read" id="inputRestrictRead">
                    <option value>Visitantes</option>
                    @foreach ($groups as $group)
                    <option value="{{ $group->key }}" {{ $forum->restrict_read == $group->key ? 'selected' : '' }}>
                        {{ $group->value['display_name'] }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputRestrictWrite" class="col-sm-2 col-form-label">Quem pode escrever?</label>
            <div class="col-sm-10">
                <select class="custom-select" name="restrict_write" id="inputRestrictWrite" required>
                    @foreach ($groups as $group)
                    <option value="{{ $group->key }}" {{ $forum->restrict_write == $group->key ? 'selected' : '' }}>
                        {{ $group->value['display_name'] }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputDescription" class="col-sm-2 col-form-label">Descrição</label>
            <div class="col-sm-10">
                <textarea class="form-control" id="inputDescription" rows="3"
                    name="description">{{ $forum->description }}</textarea>
            </div>
        </div>

        <hr>

        <div class="form-group row">
            <label for="inputThreadsRestrictRead" class="col-sm-2 col-form-label">Quem pode ler?</label>
            <div class="col-sm-10">
                <select class="custom-select" name="threads_restrict_read" id="inputThreadsRestrictRead">
                    <option value>Visitantes</option>
                    @foreach ($groups as $group)
                    <option value="{{ $group->key }}" {{ $forum->threads_restrict_read == $group->key ? 'selected' : '' }}>
                        {{ $group->value['display_name'] }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputThreadsRestrictWrite" class="col-sm-2 col-form-label">Quem pode escrever?</label>
            <div class="col-sm-10">
                <select class="custom-select" name="threads_restrict_write" id="inputThreadsRestrictWrite" required>
                    @foreach ($groups as $group)
                    <option value="{{ $group->key }}" {{ $forum->threads_restrict_write == $group->key ? 'selected' : '' }}>
                        {{ $group->value['display_name'] }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="ml-auto">
            <a href="{{ route('admin.tree') }}" class="btn btn-secondary">Cancelar</a>
            <button class="btn btn-primary ml-auto" type="submit">Salvar</button>
        </div>
    </form>
</div>

@stop