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
    Schema::table('langganans', function (Blueprint $table) {
        $table->decimal('harga_subs', 12, 2)->change();
    });
}

public function down()
{
    Schema::table('langganans', function (Blueprint $table) {
        $table->decimal('harga_subs', 8, 2)->change();
    });
}
};
