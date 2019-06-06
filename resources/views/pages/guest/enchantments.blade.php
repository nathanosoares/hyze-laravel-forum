@extends('layouts.forum')

@push('styles')
<link href="https://fonts.googleapis.com/css?family=Cinzel|Cinzel+Decorative" rel="stylesheet">

<style>
    main {
        /* color: #fff; */
        /* background: linear-gradient(rgba(0, 0, 0, 0.25), rgba(0, 0, 0, 0.55)), url(https://legend.hyze.net/images/background0.png); */
    }

    .enchants {
        margin: 20px 0;
        text-align: center;
    }

    .enchants .enchant {
        border-radius: 5px;
        padding: 40px 15px;
        border: 1px solid transparent;
    }

    .enchants .enchant:hover {
        /* border: 1px solid rgba(222, 203, 179, 0.2); */
        /* box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .7) !important; */
        /* background-color: rgba(0, 0, 0, .4) !important; */
        cursor: pointer;
    }

    .content-column {
        text-align: center;
        max-width: 80em;
        display: inline-block;
        padding: 4em;
        padding-bottom: 0em;
    }

    .enchants p {
        font-family: Open Sans, sans-serif;
        /* color: #decbb3; */
    }

    .enchants span {
        color: #676767;
    }

    .c-icon {
        width: 55px;
        height: 55px;
        display: inline-block;
    }

    .c-icon.c-icon-dungeons {
        background: url(https://legend.hyze.net/images/dungeons-icon.png);
    }

    .c-icon.c-icon-mysterybox {
        background: url(https://legend.hyze.net/images/mysterybox-icon.png);
    }

    .c-icon.c-icon-the-end {
        background: url(https://legend.hyze.net/images/the-end-icon.png);
    }

    .c-icon.c-icon-divine-book {
        background: url(https://legend.hyze.net/images/divine-book-icon.png);
    }

    .text-chalky {
        /* color: #ECD19A; */
    }

    .cinzel {
        /* font-family: "Cinzel Decorative", "Palatino Light", Times, Times New Roman, Georgia; */
    }
</style>
@endpush

@section('content')
<h1 class="text-center my-4 text-chalky cinzel text-uppercase">Encantamentos Divinos</h1>

{{-- <div class="bg-white rounded shadow-sm py-4">
    @foreach ($enchantments as $enchantment)
    <ul>
        <li>
            <strong>{{ $enchantment->name }}</strong> ({{ $enchantment->parts }})<br>
{{ $enchantment->description }}<br>
<strong>Onde conseguir:</strong> Livro de Encatamentos Divinos
</li>
</ul>
@endforeach
</div> --}}

<div class="row enchants">

    @foreach ($enchantments as $enchantment)
    <div class="d-flex col-6 mb-4">
        {{-- <div class="d-flex flex-column enchant rounded"> --}}
        <div class="d-flex bg-white flex-column enchant rounded shadow-sm w-100">
            <h3 class="m-0 cinzel text-chalky text-uppercase">{{ $enchantment->name }}</h3>
            <span class="mb-2">{{ $enchantment->parts }}</span>
            <p class="text-lg">{{ $enchantment->description }}</p>

            <div class="mt-auto">
                <p class="text-muted font-weight-lighter mb-2">Onde conseguir:</p>
                @foreach ($enchantment->icons as $icon)
                <span data-toggle="c-icon" data-icon="{{ $icon }}" class="c-icon c-icon-{{ $icon }}"></span>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach

</div>
@endsection

@push('scripts')
<script>
    function getCustomIconText(iconId) {
          switch (iconId) {
            case 'divine-book':
              return 'Livro de Encantamentos Divinos<br>Use <strong>/kit</strong> para comprar';
            case 'mysterybox':
              return 'Caixas Misteriosas';
            case 'the-end':
              return 'The End';
            case 'dungeons':
              return 'Dungeons';
            default:
              return '';
          }
        }
    
        $(function () {
          $('[data-toggle="c-icon"]').each((index, value) => {
            $(value).popover({
              content: getCustomIconText($(value).data('icon')),
              placement: 'top',
              trigger: 'hover',
              html: true
            });
    
            $(value).addClass('c-icon c-icon-' + $(value).data('icon'));
          });
    
          //$('[data-toggle="popover"]').popover()
        })
</script>
@endpush