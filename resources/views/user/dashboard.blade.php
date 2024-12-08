<!-- resources/views/user/dashboard.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Welcome, {{ $user->name }}</h1>

    <h3>Personal Information</h3>
    <ul>
        <li>Name: {{ $user->name }}</li>
        <li>Email: {{ $user->email }}</li>
        <li>Joined: {{ $user->created_at->format('Y-m-d') }}</li>
    </ul>
    
    <a href="{{ route('user.edit') }}" class="btn btn-primary">Edit Profile</a>
    @if (Auth::user()->role == 'user')
        
    
        <h3>Your Shop</h3>
        @if (Auth::user()->shop == null)
            You Don't have a shop: <a class="btn btn-info" href="{{ route('shop.register') }}">Register a Shop</a>
        @else
            <ul>
                {{-- @foreach ($user->shops as $shop) --}}
                <img src="{{ asset('storage/' . $user->shop->logo) }}" alt="{{ $user->shop->name }} Logo" class="img-fluid" width="150">
                <li><a href="{{ route('shop.dashboard', $user->shop->id) }}">{{ $user->shop->name }}</a></li>
                {{-- @endforeach --}}
            </ul>
        @endif
        <h3>Your Orders</h3>
        <a href="{{ route('orders.index') }}" class="btn btn-info">View Orders</a>
    @endif
</div>
@endsection
