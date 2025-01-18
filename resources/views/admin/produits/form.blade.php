@extends('admin.admin')

@section('title', $produit->exists? 'Editer le produit' : 'Ajouter un produit')

@section('content')
    <h1>@yield('title')</h1>
    <form action="{{route($produit->exists ? 'admin.produit.update' : 'admin.produit.store', $produit)}}" method="post">
        @csrf
        @method($produit->exists ? 'put' : 'post')
        <div class="row">
        
            <div class="col row mb-3">
                @include('shared.input', ['class' => 'col', 'name' => 'titre', 'label' => 'Titre', 'value' => $produit->titre])
                @include('shared.input', ['class' => 'col', 'name' => 'nombre', 'label' => 'Nombre', 'value' => $produit->nombre])
                @include('shared.input', ['class' => 'col', 'name' => 'montant', 'label' => 'Montant', 'value' => $produit->montant])
            </div>
            @include('shared.select', ['name' => 'types', 'label' => 'Types', 'value' => $produit->types()->pluck('id'), 'multiple' => true])
            @include('shared.checkbox', ['name' => 'etat', 'label' => 'Etat normal', 'value' => $produit->etat])

            <div>
                <button class="btn btn-primary">
                    @if ($produit->exists)
                        Modifier
                    @else
                        Créer
                    @endif
                </button>
            </div>
        </div>
    </form>
@endsection