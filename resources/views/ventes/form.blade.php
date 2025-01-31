@extends('admin.admin')

@section('title', $vente->exists? 'Editer le vente' : 'Ajouter un vente')

@section('content')
    <h1>@yield('title')</h1>
    @if (session('error'))
            <div class="alert alert-danger">
                {{ session(key: 'error') }}
            </div>
        @endif

    <form action="{{route($vente->exists ? 'boutique.vente.update' : 'boutique.vente.store', $vente)}}" method="post">
        @csrf
        @method($vente->exists ? 'put' : 'post')
        <div class="row d-flex justify-content-center mt-5">
            <input type="hidden" name="user_id" value={{ $vente->user_id }}>
            <input type="hidden" name="statut" value={{ $vente->statut }}>
            <div class="d-flex flex-column mb-3 col-10">
                @include('shared.select', ['class' => 'col mb-3', 'name' => 'types', 'label' => 'Types', 'value' => $vente->types()->pluck('id')])
                @include('shared.selectProduit', ['class' => 'col', 'name' => 'produit_id', 'label' => 'A partir du stock', 'value' => $vente->produit()->pluck('id'), 'multiple' => false])
                @include('shared.input', ['class' => 'col', 'name' => 'designation', 'label' => 'Désignation', 'type' => 'text', 'value' => $vente->designation])
                @include('shared.input', ['class' => 'col', 'name' => 'nombre', 'label' => 'Nombre','type' => 'number', 'value' => $vente->nombre])
                @include('shared.input', ['class' => 'col', 'name' => 'prix', 'label' => 'Prix','type' => 'number', 'value' => $vente->prix])
                {{-- @include('shared.input', ['name' => 'image', 'label' => 'Image', 'type' => 'file']) --}}
            </div>
            {{-- <label class="mb-1">Image</label>
            <input type="file" name="image" class="form-control" value="{{ old('image') }}"> --}}
            {{-- @include('shared.checkbox', ['name' => 'etat', 'label' => 'Etat normal', 'value' => $vente->etat]) --}}
            <div>
                <button class="btn btn-primary">
                    @if ($vente->exists)
                        Modifier
                    @else
                        Créer
                    @endif
                </button>
            </div>
        </div>
    </form>
@endsection