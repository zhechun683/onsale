<?php
namespace Database\Seeders;

use App\Models\Invitation;
use Illuminate\Database\Seeder;

class InvitationSeeder extends Seeder
{
    public function run()
    {
        // Create 10 random invitation codes
        for ($i = 0; $i < 10; $i++) {
            Invitation::create([
                'code' => Invitation::generateCode(),
                'used' => false, // Make sure the code is initially unused
            ]);
        }
    }
}
