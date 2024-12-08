<!-- resources/views/shop/dashboard.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Welcome to your Shop Dashboard</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($shop)
        <p>Shop Name: {{ $shop->name }}</p>
        <p>Shop Description: {{ $shop->description }}</p>
        @if ($shop->logo)
            <img src="{{ asset('storage/' . $shop->logo) }}" alt="{{ $shop->name }} Logo" class="img-fluid" width="150">
        @else
            <p>No logo uploaded.</p>
        @endif
        <a href="{{ route('shop.edit') }}" class="btn btn-primary">Edit Shop Details</a>
        <h1>{{ $shop->name }} - Manage products</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    
        <div class="mb-3">
            <a href="{{ route('shop.products.create', $shop) }}" class="btn btn-success">Upload New Products</a>
        </div>
        <h1>Check Orders</h1>
            {{-- <a href="{{ route('orders.shop') }}" class="btn btn-info">View Orders</a> --}}

        <div class="mb-3">
            <a href="{{ route('orders.shop') }}" class="btn btn-success">Check Orders</a>
        </div>
        <h1>Products List</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Product Picture</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>price</th>
                    <th>Stock</th>
                    <th>Operation</th>
                </tr>
            </thead>
            <tbody>
                @foreach($shop->products as $product)
                    <tr>
                        <td><img src="{{ asset('storage/' . $product->image) }}" class="img-fluid" width="150"></td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ number_format($product->price, 2) }} $</td>
                        <td>{{ number_format($product->stock) }}</td>
                        
                        <td>

                            <a href="{{ route('shop.products.edit', ['shop' => $shop, 'product' => $product]) }}" class="btn btn-primary">Edit</a>
    

                            <form action="{{ route('shop.products.destroy', ['shop' => $shop, 'product' => $product]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are You Sure To Delete This?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <!-- Add other shop-related data here -->

</div>
@endsection
