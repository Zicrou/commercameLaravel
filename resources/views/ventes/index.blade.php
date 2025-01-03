@extends('base')

@section('title', 'Ventes')
@section('content')
<div class="bg-light p-5 mb-5 text-center">
    <form action="" method="get" class="container d-flex gap-2">
        <input type="number" placeholder="Budget max" class="form-control" name="price" value="{{ $input['price'] ?? ''}}">
        <input type="text" placeholder="Mot clef" class="form-control" name="title" value="{{ $input['title'] ?? ''}}">
        <button class="btn btn-primary btn-sm flex-grow-0">
            Rechercher
        </button>
    </form>
</div>

<div class="container">
    <div class="row">
        <a href="{{ route('vente.create')}}" class="btn btn-primary col-md-3">Ajouter une vente</a>
        {{-- @forelse ($ventes as $vente)
            <div class="col-12 mb-4">
                @include('vente.card')
            </div>
        @empty
            <div class="col">
                Aucune ventes ne correspond à votre recherche
            </div>
        @endforelse --}}
    </div>
</div>

<div class="my-4">
    {{-- {{ $ventes->links() }} --}}
</div>
@endsection