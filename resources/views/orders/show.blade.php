@extends('layouts.app')

@section('content')
    <h2>Order Details</h2>
    <label for="Status" class="form-label">Order Status:{{ $order->status }}</label>
    <label for="Price" class="form-label">Total Price: ${{ number_format($order->totalAmount(),2) }}</label>
    {{-- <input type="text" name="Status" id="Status" class="form-control"  required> --}}

    <h3>Order Items</h3>
    <ul>
        @foreach ($order->items as $item)
            <li>{{ $item->product->name }} (x{{ $item->quantity }}) - ${{ $item->price }}</li>
        @endforeach
    </ul>

    {{-- @if ($order->status === 'pending') --}}
    @if (Auth::user()->id === $order->user_id && $order->status === 'pending')
        <form action="{{ route('orders.complete', $order->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Confirm Order Completion</button>
        </form>
    @elseif (Auth::user()->id === $order->shop->user_id && $order->status === 'hcomplete')
        <form action="{{ route('orders.complete', $order->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Mark as Completed</button>
        </form>
    @endif
    {{-- @endif --}}
@endsection