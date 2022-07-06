<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockItemsTable extends Migration {
    public function up() {
        Schema::create('stock_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_id');
            $table->string('price_name');
            $table->string('name');
            $table->string('h1')->nullable();
            $table->string('diameter')->nullable();
            $table->string('thickness')->nullable();
            $table->string('weight')->nullable();
            $table->string('gost')->nullable();
            $table->string('steel')->nullable();
            $table->string('reserved')->nullable();
            $table->boolean('in_stock')->default(0);
            $table->text('text')->nullable();
            $table->string('title')->nullable();
            $table->string('keywords')->nullable();
            $table->string('description')->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->boolean('published')->default(1);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('stock_items');
    }
}