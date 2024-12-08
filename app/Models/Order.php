<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'shop_id',
        'order_number',
        'total_price',
        'status',
    ];

        public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function totalAmount()
    {
        return $this->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }
}