<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockItemable extends Migration {
    public function up() {
        Schema::create('stock_itemables', function (Blueprint $table) {
            $table->unsignedBigInteger('stock_item_id');
            $table->morphs('stock_itemable');
        });
    }

    public function down() {
        Schema::dropIfExists('stock_itemables');
    }
}