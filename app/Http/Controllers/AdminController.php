<?php
// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Shop;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // View all users
    public function viewUsers()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    // View all stores
    public function viewShops()
    {
        $shops = Shop::all();
        return view('admin.shops', compact('shops'));
    }

    // Delete a user
    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users');
    }

    // Delete a store
    public function deleteShop(Shop $shop)
    {
        $shop->delete();
        return redirect()->route('admin.stores');
    }
}
