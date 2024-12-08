<!-- resources/views/shop/edit.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Your Shop</h1>

    <!-- Display any success message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('shop.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Shop Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $shop->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Shop Description</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $shop->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="logo" class="form-label">Shop Logo (optional)</label>
            <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
            @if($shop->logo)
                <div class="mt-3">
                    <img src="{{ asset('storage/' . $shop->logo) }}" alt="Shop Logo" class="img-fluid" width="150">
                    <p>Current Logo</p>
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Shop</button>
    </form>
</div>
@endsection
