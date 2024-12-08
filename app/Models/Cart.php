<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name'];


    public function products()
    {
        return $this->hasMany(Product::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function index()
    {
        $user = Auth::user();
        
        // 获取用户的购物车商品
        $cartItems = $user->cartItems()->with('product')->get();

        return view('cart.index', compact('cartItems'));
    }

}