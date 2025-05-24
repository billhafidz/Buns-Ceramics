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
Schema::create('members', function (Blueprint $table) {
    $table->id('id_member');
    $table->string('nama_member');
    $table->string('alamat_member');
    $table->string('no_telp');
    $table->string('email_member')->unique();
    $table->string('id_account');
    $table->string('day');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
