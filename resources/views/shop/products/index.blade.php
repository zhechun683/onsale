<!-- resources/views/shop/products/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $shop->name }} - Products</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('shop.products.create', $shop) }}" class="btn btn-success mb-3">Add New Product</a>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>
                        <a href="{{ route('shop.products.edit', ['shop' => $shop, 'product' => $product]) }}" class="btn btn-primary">Edit</a>
                        
                        <form action="{{ route('shop.products.destroy', ['shop' => $shop, 'product' => $product]) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
