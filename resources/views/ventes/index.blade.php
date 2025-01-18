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

<div class="">
    <div class="">
        <a href="{{ route('boutique.vente.create')}}" class="btn btn-primary col-md-3">Ajouter une vente</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Types</th>
                    <th>Nombre</th>
                    <th>Prix</th>
                    <th>Total</th>
                    <th>User</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ventes as $vente)
                
                    <tr>
                        <td>{{ $vente->produit->titre }}</td>
                        <td class="bg-info">
                            @foreach ( $vente->types as $type )
                                <span class="d-flex w-100 justify-content-center">{{ $type->name }}</span>
                            @endforeach ()
                                
                                
                            
                        </td>
                        <td>{{ $vente->nombre }}</td>
                        <td>{{ $vente->prix }}</td>
                        <td>{{ $total = $vente->prix * $vente->nombre }}</td>
                        <td>{{ $vente->user->name }}</td>
                        <td>
                            <div class="d-flex gap-2 w-100 justify-content-end">
                                <a href="{{ route('boutique.vente.edit', $vente) }}" class="btn btn-primary">Editer</a>
                                {{-- @can('delete', $vente) --}}
                                    <form action="{{ route('boutique.vente.destroy', $vente) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger">Supprimer</button>
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

