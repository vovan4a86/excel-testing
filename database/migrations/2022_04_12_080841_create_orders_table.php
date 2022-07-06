<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration {
    public function up() {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('text');
            $table->boolean('cut')->default(0);
            $table->boolean('delivery')->default(0);
            $table->string('stock')->nullable();

            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('orders');
    }
}