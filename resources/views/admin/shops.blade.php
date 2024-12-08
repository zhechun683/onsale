@extends('layouts.app')

@section('content')
    <h1>All Stores</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Store Name</th>
                <th>Owner</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shops as $shop)
                
                <tr>
                    <td>{{ $shop->name }}</td>
                    <td>{{ $shop->user->name }}</td>
                    <td>
                        <form action="{{ route('admin.deleteShop', $shop->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
