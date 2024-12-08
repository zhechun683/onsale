<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItemsTable extends Migration
{
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id(); // 购物车项的自增ID
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // 用户ID
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // 商品ID
            $table->integer('quantity')->default(1); // 商品数量
            $table->timestamps(); // 创建时间和更新时间
        });
    }

    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
}
