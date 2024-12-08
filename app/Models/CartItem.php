<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',    // 用户ID
        'product_id', // 商品ID
        'quantity',   // 商品数量
    ];

    /**
     * 获取所属的用户
     */
    public function user()
    {
        return $this->belongsTo(User::class); // 每个 CartItem 属于一个 User
    }

    /**
     * 获取属于的商品
     */
    public function product()
    {
        return $this->belongsTo(Product::class); // 每个 CartItem 属于一个 Product
    }
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}
