<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>所有商铺</h1>

    <div class="row">
        @foreach ($shops as $shop)
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="{{ asset('storage/' . $shop->logo) }}" class="card-img-top" alt="{{ $shop->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $shop->name }}</h5>
                        <p class="card-text">{{ Str::limit($shop->description, 100) }}</p>
                        <a href="{{ route('shop.show', $shop->id) }}" class="btn btn-primary">查看商铺</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
