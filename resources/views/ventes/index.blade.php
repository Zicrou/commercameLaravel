@extends('base')

@section('title', 'Ventes')
@section('content')
<section class="mb-5">
    <form action="" method="get" class=" d-flex gap-3">
    <div class="container">
        <div class="row align-items-center justify-content-center">
                <div class="col-12 col-lg-6 mb-3">
                    <input type="text" placeholder="Mot clef" class="form-control" name="title" value="{{ $input['title'] ?? ''}}">
                </div>
                <div class="col-12 col-lg-6 mb-3">
                    <input type="number" placeholder="Budget max" class="form-control" name="price" value="{{ $input['price'] ?? ''}}">
                </div>
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <button class="btn btn-primary px-5 py-3 d-inline-block">
                    Rechercher
                </button>
            </div>
        </div>
    </form>
</section>
<div class="">
    <div class="">
        <div class="row d-flex justify-content-end">
            <h1 class="d-flex justify-content-start"><u class="px-3">Total de la journée: </u> {{ number_format($totalOfTheDay, thousands_separator: ' ' )}} FCFA</h1>
            <h5><u class="px-3">Vente:</u>{{ number_format($totalVenteOfTheDay, thousands_separator: ' ' )}} FCFA</h5>
            <h5><u class="px-3">Réparation:</u> {{ number_format($totalReparationOfTheDay, thousands_separator: ' ' )}} FCFA</h5>
            <h5><u class="px-3">Vente & Réparation:</u> {{ number_format($totalVenteEtReparationOfTheDay, thousands_separator: ' ' )}} FCFA</h5>
            <a href="{{ route('boutique.vente.create')}}" class="btn btn-primary col-md-2 mb-3">Faire une vente</a>
        </div>        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Désignation</th>
                    <th>Types</th>
                    <th>Nombre</th>
                    <th>Prix</th>
                    <th>Total</th>
                    <th>User</th>
                    <th>Provenant</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ventes as $vente)
            {{-- <h1 class="d-flex justify-content-start"><u class="px-3">Total de la journée: </u> {{ number_format($totalOfTheDay, thousands_separator: ' ' )}} FCFA</h1> --}}
               
                    <tr>
                        @if ($vente->designation)
                            <td>{{ $vente->designation }}</td>
                        @elseif ($vente->produit_id)
                            <td>{{ $vente->produit->designation }}</td>
                        @else
                        @endif
                        <td class="bg-info">
                            @foreach ( $vente->types as $type )
                                <span class="d-flex w-100 justify-content-center">{{ $type->name }}</span>
                            @endforeach ()
                        </td>
                        <td>{{ $vente->nombre }}</td>
                        <td>{{ $vente->prix }}</td>
                        <td>{{ $total = $vente->prix * $vente->nombre }}</td>
                        <td>{{ $vente->user->name }}</td>
                        @if ($vente->designation)
                            <td>Désignation</td>
                        @else
                            <td>Stock</td>
                        @endif
                        <td>
                            <div class="d-flex gap-2 w-100 justify-content-end">
                                <a href="{{ route('boutique.vente.edit', $vente) }}" class="btn btn-primary">Editer</a>
                                {{-- @can('delete', $vente) --}}
                                    <form action="{{ route('boutique.vente.destroy', $vente) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger">Annuler</button>
                                    </form>
                                {{-- @endcan --}}
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="my-4">
    {{ $ventes->links() }}
</div>
@endsection

