@extends('admin.admin')

@section('title', $vente->exists? 'Editer le vente' : 'Ajouter un vente')
@php
$route = request()->route()->getName();
// dd($vente);
@endphp
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
                @if (str_contains($route, 'edit'))
                    @if (!$vente->designation)
                        <h4>{{ $vente->produit->designation }}: stock</h4>
                        <input type="hidden" name="produit_id" value={{ $vente->produit_id }}>
                    @elseif (!$vente->produit_id)
                        @include('shared.input', ['class' => 'col', 'name' => 'designation', 'label' => 'Désignation', 'type' => 'text', 'value' => $vente->designation])
                    @endif 
                @elseif (str_contains($route, 'create'))
                    <div class="row">
                        <div class="col-10 col-lg-5">
                            @include('shared.selectProduit', ['class disabled' => 'col', 'name' => 'produit_id', 'label' => 'A partir du stock', 'value' => $vente->produit()->pluck('id'), 'disabled' => true, 'multiple' => false])
                        </div>
                        <span class="fw-bold fs-2 ps-5 col-lg-2">Ou</span>
                        <div class="col-10 col-lg-5">
                            @include('shared.input', ['class' => 'col', 'name' => 'designation', 'label' => 'Désignation', 'type' => 'text', 'value' => $vente->designation])
                        </div>
                    </div>
                @endif
                <div class="row mt-4">
                    <div class="col-12 col-lg-6 mb-3">
                        @include('shared.input', ['class' => 'col', 'name' => 'nombre', 'label' => 'Nombre','type' => 'number', 'value' => $vente->nombre])
                    </div>
                    <div class="col-12 col-lg-6">
                        @include('shared.input', ['class' => 'col', 'name' => 'prix', 'label' => 'Prix','type' => 'number', 'value' => $vente->prix])
                    </div>
                </div>
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