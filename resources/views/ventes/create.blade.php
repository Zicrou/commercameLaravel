@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Vente</h1>
    <form action="{{ route('ventes.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="product">Product</label>
            <input type="text" class="form-control" id="product" name="product" required>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" required>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="text" class="form-control" id="price" name="price" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Vente</button>
    </form>
</div>
@endsection
