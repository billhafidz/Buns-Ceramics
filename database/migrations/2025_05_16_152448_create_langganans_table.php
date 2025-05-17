<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('langganans', function (Blueprint $table) {
            $table->id('id_langganan');
            $table->string('pilihan_subs');
            $table->text('penjelasan_subs');
            $table->json('benefit_subs');
            $table->decimal('harga_subs', 8, 2);
            $table->string('gambar_subs')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('langganans');
    }
};