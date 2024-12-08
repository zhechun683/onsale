@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Shop Orders</h2>

    @if($orders->isEmpty())
        <p>You have no orders yet.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Status</th>
                    <th>Total Price</th>
                    <th>Items</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>${{ number_format($order->totalAmount(), 2) }}</td>
                        <td>
                            @foreach ($order->items as $item)
                                {{ $item->product->name }} (x{{ $item->quantity }})<br>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-sm">View</a>
                            @if($order->status == 'hcomplete')
                                @if(Auth::user()->id === $order->shop->user_id)
                                    <form action="{{ route('orders.complete', $order->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Complete Order</button>
                                    </form>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
