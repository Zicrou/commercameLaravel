@extends('base')

@section('title', 'Ventes')
@section('content')
<div class="bg-light p-5 mb-5 text-center">
    <form action="" method="get" class="container d-flex gap-2">
        <input type="text" placeholder="Mot clef" class="form-control" name="title" value="{{ $input['title'] ?? ''}}">
        <input type="number" placeholder="Budget max" class="form-control" name="price" value="{{ $input['price'] ?? ''}}">
        <button class="btn btn-primary btn-sm flex-grow-0">
            Rechercher
        </button>
    </form>
</div>
@php
//  $totalOfTheDay = 0;
//  $totalVenteOfTheDay= 0;
//  $totalReparationOfTheDay= 0;
//  $totalVenteEtReparationOfTheDay= 0;
// foreach ($ventes as $vente){
//     $total = $vente->prix * $vente->nombre;
//     $totalOfTheDay += $total;
//     $type_vente = $vente->types()->get();
//     foreach ($type_vente as $tv) {
//         // dd($tv->name);
//         if($tv->id == 1){
//             $total = $vente->prix * $vente->nombre;
//             $totalVenteOfTheDay += $total;
//         }elseif ($tv->id == 2) {
//             $total = $vente->prix * $vente->nombre;
//             $totalReparationOfTheDay += $total;
//         }elseif ($tv->id == 4) {
//             $total = $vente->prix * $vente->nombre;
//             $totalVenteEtReparationOfTheDay += $total;
//         }

//     }

// }
@endphp
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

