@extends('base')

@section('title', $type->exists? 'Editer le type' : 'Ajouter un type')

@section('content')
    <h1>@yield('title')</h1>
    <form action="{{route($type->exists ? 'admin.type.update' : 'admin.type.store', $type)}}" method="post">
        @csrf
        @method($type->exists ? 'put' : 'post')
        <div class="row d-flex justify-content-center">
        
            <div class="col-12 col-xm-12 col-lg-6 row mb-3">
                @include('shared.input', ['class' => 'col', 'name' => 'name', 'label' => 'Titre', 'value' => $type->name])
            </div>
            <div class="row d-flex justify-content-center mt-3">
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