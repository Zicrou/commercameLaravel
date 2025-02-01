@extends('base')

@section('title', $type->exists? 'Editer le type' : 'Ajouter un type')

@section('content')
    <h1>@yield('title')</h1>
    <form action="{{route($type->exists ? 'admin.type.update' : 'admin.type.store', $type)}}" method="post">
        @csrf
        @method($type->exists ? 'put' : 'post')
        <div class="row">
        
            <div class="col row mb-3">
                @include('shared.input', ['class' => 'col', 'name' => 'name', 'label' => 'Titre', 'value' => $type->name])
            </div>
            <div>
                <button class="btn btn-primary">
                    @if ($type->exists)
                        Modifier
                    @else
                        Créer
                    @endif
                </button>
            </div>
        </div>
    </form>
@endsection