<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'image', 'shop_id'];
    
    // Define the relationship with the Shop model
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($product) {
            // 删除商品图片
            if ($product->image && Storage::exists('public/' . $product->image)) {
                Storage::delete('public/' . $product->image);
            }
        });
    }
    public function cartItems()
    {
        return $this->hasMany(CartItem::class); // 每个商品可以出现在多个 CartItem 中
    }
}
