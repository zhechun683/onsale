<!-- resources/views/shop/show.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>{{ $shop->name }} - Shop Details</h1>
    
    <!-- 显示商铺的描述 -->
    <p>{{ $shop->description }}</p>

    <h2>Product List</h2>
    <div class="row">
        @foreach ($shop->products as $product)
            @if ($product->stock > 0)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <!-- 商品图片，点击图片跳转到商品详情页面 -->
                        <a href="{{ route('product.show', $product->id) }}">
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                            <p><strong>Stock:</strong> {{ $product->stock }} Items</p>
                            <a href="{{ route('product.show', $product->id) }}" class="btn btn-primary">See For Details</a>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endsection
