<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageFieldToStockItems extends Migration {
    public function up() {
        Schema::table('stock_items', function (Blueprint $table) {
            $table->string('image')
                ->after('h1')
                ->nullable();
        });
    }

    public function down() {
        Schema::table('stock_items', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
}