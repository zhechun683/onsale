<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'used',
    ];

    // Optionally, you can add some custom logic to handle the invitation status
    public static function generateCode()
    {
        // Generate a random invitation code (you can customize this as needed)
        return strtoupper(bin2hex(random_bytes(5)));
    }
}
