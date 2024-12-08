<!-- resources/views/shop/products/edit.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Product</h1>

    <form action="{{ route('shop.products.update', ['shop' => $shop, 'product' => $product]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')

        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ $product->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}" step="0.01" min="0" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Product Image</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="img-fluid mt-2" width="150">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
</div>
@endsection
