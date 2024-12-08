<!-- resources/views/shop/register.blade.php -->
@extends('layouts.app')

@section('content')
    <h2>Register Shop</h2>

    <form method="POST" action="{{ route('shop.register') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Shop Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Shop Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="contact_phone" class="form-label">Phone number</label>
            <input type="text" name="contact_phone" id="contact_phone" class="form-control" value="{{ old('contact_phone') }}">
            @error('contact_phone') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="logo" class="form-label">Shop Logo (optional)</label>
            <input type="file" name="logo" id="logo" class="form-control">
            @error('logo') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Register</button>
    </form>
@endsection
