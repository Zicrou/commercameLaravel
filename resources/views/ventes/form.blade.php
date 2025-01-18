@extends('admin.admin')

@section('title', $vente->exists? 'Editer le vente' : 'Ajouter un vente')

@section('content')
    <h1>@yield('title')</h1>
    <form action="{{route($vente->exists ? 'boutique.vente.update' : 'boutique.vente.store', $vente)}}" method="post">
        @csrf
        @method($vente->exists ? 'put' : 'post')
        <div class="row justify-content-center">
            <input type="hidden" name="user_id" value={{ $vente->user_id }}>
            <input type="hidden" name="statut" value={{ $vente->statut }}>
            <div class="col d-flex flex-column row mb-3 col-10">
                @include('shared.select', ['class' => 'col-5', 'name' => 'types', 'label' => 'Types', 'value' => $vente->types()->pluck('id'), 'multiple' => true])
                @include('shared.selectProduit', ['class' => 'col-5', 'name' => 'produit_id', 'label' => 'Produits', 'value' => $vente->produit()->pluck('id'), 'multiple' => false])
                @include('shared.input', ['class' => 'col-3', 'name' => 'nombre', 'label' => 'Nombre','type' => 'number', 'value' => $vente->nombre])
                @include('shared.input', ['class' => 'col-4', 'name' => 'prix', 'label' => 'Prix','type' => 'number', 'value' => $vente->prix])
            </div>
            @include('shared.checkbox', ['name' => 'etat', 'label' => 'Etat normal', 'value' => $vente->etat])
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