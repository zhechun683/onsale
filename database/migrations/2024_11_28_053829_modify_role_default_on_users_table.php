<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['guest', 'user', 'admin'])->default('guest')->change();
        });
    }
    
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['guest', 'user', 'admin'])->default('guest')->change();
        });
    }
};
