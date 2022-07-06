<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOnCatalogToCatalogs extends Migration {
    public function up() {
        Schema::table('catalogs', function (Blueprint $table) {
            $table->boolean('on_catalog')
                ->after('on_main')
                ->default(1);
        });
    }

    public function down() {
        Schema::table('catalogs', function (Blueprint $table) {
            $table->dropColumn(['on_catalog']);
        });
    }
}
