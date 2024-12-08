<!-- resources/views/cart.blade.php -->
@extends('layouts.app')

@section('content')
    <h2>购物车</h2>

    @if (count($cartItems) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>商品</th>
                    <th>数量</th>
                    <th>单价</th>
                    <th>小计</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cartItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>¥{{ number_format($item->product->price, 2) }}</td>
                        <td>¥{{ number_format($item->product->price * $item->quantity, 2) }}</td>
                        <td><a href="/cart/remove/{{ $item->id }}" class="btn btn-danger">删除</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h4>总价：¥{{ number_format($totalPrice, 2) }}</h4>
        <a href="/checkout" class="btn btn-success">结算</a>
    @else
        <p>您的购物车是空的。</p>
    @endif
@endsection
