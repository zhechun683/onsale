<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Shop extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',          // Add 'name' to the fillable property
        'contact_phone',
        'logo',
        'user_id',       // Assuming you also have a user_id to associate the shop with a user
        'description',
        // Add other fields as needed
    ];
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($shop) {
            foreach ($shop->products as $product) {
                if ($product->image && Storage::exists('public/' . $product->image)) {
                    Storage::delete('public/' . $product->image);
                }
                $product->delete();
            }

            if ($shop->logo && Storage::exists('public/' . $shop->logo)) {
                Storage::delete('public/' . $shop->logo);
            }
        });
    }
}
