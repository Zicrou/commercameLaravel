@extends('admin.admin')

@section('title', 'Tous les produits')

@section('content')

    <div class="row">
        <div class="d-flex justify-content-between align-items-center">
            <h1>@yield('title')</h1>
            <a href="{{ route('admin.produit.create') }}" class="btn btn-primary">Ajouter un produit</a>
        </div>
    
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Nombre</th>
                    <th>Montant</th>
                    <th>Etat</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produits as $produit)
                
                    <tr>
                        <td>{{ $produit->titre }}</td>
                        <td>{{ $produit->nombre }}</td>
                        <td>{{ number_format($produit->montant, thousands_separator: ' ') }}</td>
                        @if ($produit->etat == 0)
                            <td><span class="badge bg-danger">A répparer</span></td>
                        @else
                            <td><span class="badge bg-success">Normal</span></td>
                        @endif
                        <td>
                            <div class="d-flex gap-2 w-100 justify-content-end">
                                {{-- <a href="{{ route('admin.upload.image', $produit) }}" class="btn btn-primary">Images</a>
                                <a href="{{ route('admin.picture.index', $produit) }}" class="btn btn-primary">Picture</a> --}}
                                <a href="{{ route('admin.produit.edit', $produit) }}" class="btn btn-primary">Editer</a>
                                {{-- @can('delete', $produit) --}}
                                    <form action="{{ route('admin.produit.destroy', $produit) }}" method="post">
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
    
        {{ $produits->links() }}
    
    </div>
@endsection