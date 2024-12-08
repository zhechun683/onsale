<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>All Shops</h1>

    <div class="row">
        @foreach ($shops as $shop)
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="{{ asset('storage/' . $shop->logo) }}" class="card-img-top" alt="{{ $shop->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $shop->name }}</h5>
                        <p class="card-text">{{ Str::limit($shop->description, 100) }}</p>
                        <p><strong>The Owner:</strong> {{ $shop->user->name }}</p>
                        <a href="{{ route('shop.show', $shop->id) }}" class="btn btn-primary">Show Shop Detail</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
