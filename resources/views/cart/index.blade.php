<!-- resources/views/cart/index.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Shopping Cart</h1>

    @if($cartItems->isEmpty())
        <p>Your shopping cart is empty.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Unit Price/$</th>
                    <th>Quantity</th>
                    <th>Total Price/$</th>
                    <th>Operation</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $cartItem)
                    <tr>
                        <td>{{ $cartItem->product->name }}</td>
                        <td>{{ $cartItem->product->price }}</td>
                        <td>{{ $cartItem->quantity }}</td>
                        <td>{{ $cartItem->quantity * $cartItem->product->price }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $cartItem->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <form action="{{ route('orders.checkout') }}" method="GET">
            @csrf
            <button type="submit" class="btn btn-primary">Submit Orders</button>
        </form>
    @endif
@endsection
