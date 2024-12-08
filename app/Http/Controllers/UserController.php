<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Show the user dashboard
    public function dashboard()
    {
        $user = Auth::user();
        return view('user.dashboard', compact('user'));
    }

    // Show the edit profile page
    public function edit()
    {
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }

    // Update the user's personal information
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|min:8|confirmed', // optional password change
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;

        // If password is provided, hash it and update
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('user.dashboard')->with('success', 'Profile updated successfully!');
    }
    // 注册为用户
    public function viewProducts()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 默认将新用户设置为普通用户（'user'）
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',  // 默认角色为 'user'
        ]);

        Auth::login($user);
        dd('Here?');
        return redirect()->route('products.index');
    }
}