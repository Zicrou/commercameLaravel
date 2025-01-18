@extends('admin.admin')

@section('title', 'Tous les types')

@section('content')

    <div class="d-flex justify-content-between align-items-center">
        <h1>@yield('title')</h1>
        <a href="{{ route('admin.type.create') }}" class="btn btn-primary">Ajouter un type</a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Titre</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($types as $type)
            
                <tr>
                    <td>{{ $type->name }}</td>
                    <td>
                        <div class="d-flex gap-2 w-100 justify-content-end">
                            <a href="{{ route('admin.type.edit', $type) }}" class="btn btn-primary">Editer</a>
                            {{-- @can('delete', $type) --}}
                                <form action="{{ route('admin.type.destroy', $type) }}" method="post">
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

    {{ $types->links() }}

@endsection