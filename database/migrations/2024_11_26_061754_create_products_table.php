<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // 自动创建 unsigned bigInteger 类型的 id 字段作为主键
            $table->string('name'); // 商品名称
            $table->decimal('price', 8, 2); // 商品价格
            $table->integer('stock'); // 商品库存
            $table->timestamps(); // 创建时间和更新时间
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
