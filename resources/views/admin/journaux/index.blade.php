@extends('base')

@section('title', 'Ventes')
@section('content')
<section class="mb-5">
    {{-- <form action="" method="get" class=" d-flex gap-3">
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
    </form> --}}
</section>
@php
use Carbon\Carbon;
$totalDepense = 0;
foreach ($depenses as $date => $depense) {
    // echo $date. "\n";
    foreach ($depense as $dep) {
        $totalDepense += $dep->montant;
    }
}
foreach ($depenses as $dateYear => $depense) {
    $dy = Carbon::createFromFormat('m-Y', $dateYear)->format('Y');
}
@endphp

<div class="">
    <div class="">
        <div class="row d-flex justify-content-center">
            @php
               $total_amount_year = [];
            //    $totalKey = '';
                foreach ($ventes_year as $key => $venteGroup) {
                    $total = 0;
                    foreach ($venteGroup as $vente) {
                        $total += $vente->nombre * $vente->prix;
                    }
                    
                    $total_amount_year[$key] = $total;
                }
                foreach ($total_amount_year as $year => $amount) {
                    // echo $year . ' : ' . $amount . '<br/>';
                    if ($dy == $year) {
                        echo '<h1 class="mx-3 btn btn-outline-primary col-5 d-flex  justify-content-around"><u class="px-3">Total annuel '. $year .': </u> ' . number_format($amount + $totalDepense, 0, '.', ' ' ) . ' FCFA</h1>';
                    }else{
                        echo '<h1 class="mx-3 btn btn-outline-primary col-5 d-flex  justify-content-around"><u class="px-3">Total annuel '. $year .': </u> ' . number_format($amount, 0, '.', ' ' ) . ' FCFA</h1>';
                    }
                    
                }
            @endphp
        </div>        
        @foreach ($ventes as $key => $venteGroup) 

        <table class="table table-striped mb-1">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Type</th>
                    <th>Nombre</th>
                    <th>Prix</th>
                    <th>Total</th>
                    <th>User</th>
                    {{-- <th>Dépense</th> --}}
                    <th>Date</th>
                    {{-- <th class="text-end">Actions</th> --}}
                </tr>
            </thead>
            <tbody>
                @php
                    $totalMonth = 0;
                @endphp
                
                <tr>
                    @php
                        foreach ($venteGroup as $vente){
                            $totalMonth += $vente->nombre *  $vente->prix;
                        }
                    @endphp
                    <h1>
                        @if ($date ==  $key)
                            {{ "Mois-Année: " . $key . " // Total : " . $totalMonth +  $totalDepense . "FCFA"}}
                        @else
                            {{ "Mois-Année: " . $key . " // Total : " . $totalMonth . "FCFA"}}
                        @endif
                    </h1> 
                    @foreach ($venteGroup as $vente)
                        @if ($vente->designation)
                            <td>{{ $vente->designation }}</td>
                        @elseif ($vente->produit)
                            <td>{{ $vente->produit->designation }}</td>
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
                        
                        
                        <td>{{ $vente->created_at }}</td>
                        <td>
                            {{-- <div class="d-flex gap-2 w-100 justify-content-end">
                                <a href="{{ route('boutique.vente.edit', $vente) }}" class="btn btn-primary">Editer</a>
                                    <form action="{{ route('boutique.vente.destroy', $vente) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger">Supprimer</button>
                                    </form>
                            </div> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if ($date ==  $key)
            <div class="mt-0 pt-0">
                <p class="mt-0 pt-0 fw-bold fs-3"><u>Total dépense {{$key}}:</u>  {{ $totalDepense }}</p> 
            </div>
        @else
            <div class="mt-0 pt-0">
                <p class="mt-0 pt-0 fw-bold fs-3">Pas de dépense </p> 
            </div>
        @endif
        <div class="" style="height: 4rem;"></div>
        @endforeach

    </div>
</div>

<div class="my-4">
    {{-- {{ $vents->links() }} --}}
</div>
@endsection

