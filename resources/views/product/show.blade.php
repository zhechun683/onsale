<!-- resources/views/product/show.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>{{ $product->name }}</h1>
    
    <!-- 商品图片 -->
    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid" alt="{{ $product->name }}">
    <p><strong>Price:</strong> {{ $product->price }} $</p>
    <p><strong>Stockpiles:</strong> {{ $product->stock }} 件</p>
    <p>{{ $product->description }}</p>

    <form action="{{ route('cart.add', $product->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success">Add To My Cart</button>
    </form>
@endsection
