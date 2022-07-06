<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusFieldToCatalogs extends Migration {
    public function up() {
        Schema::table('catalogs', function (Blueprint $table) {
            $table->text('status')
                ->after('text_prev')
                ->nullable();
        });
    }

    public function down() {
        Schema::table('catalogs', function (Blueprint $table) {
            $table->dropColumn(['status']);
        });
    }
}
