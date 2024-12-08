<?php
// database/migrations/xxxx_xx_xx_create_shops_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 商铺名称
            $table->string('description')->nullable(); // 商铺描述
            $table->string('contact_phone')->nullable(); // 商铺联系电话
            $table->string('logo')->nullable(); // 商铺logo
            $table->unsignedBigInteger('user_id'); // 用户ID（与users表关联）
            $table->timestamps();

            // 设置外键约束，确保商铺属于某个用户
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('shops');
    }
}

