@extends('layouts.app')

@section('content')
    <h2>Checkout</h2>
    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" name="address" id="address" class="form-control"  required>

        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" name="phone" id="phone" class="form-control"  required>

        </div>


        <button type="submit" class="btn btn-primary">Complete Checkout</button>

    </form>
@endsection