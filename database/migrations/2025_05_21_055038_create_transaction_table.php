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
Schema::create('transactions', function (Blueprint $table) {
    $table->id();
    $table->string('nama_kelas');
    $table->decimal('total_transaksi', 10, 2);
    $table->unsignedBigInteger('id_pelanggan');
    $table->dateTime('tanggal_transaksi');
    $table->string('order_id');
    $table->string('payment_method');
    $table->timestamps();

    $table->foreign('id_pelanggan')->references('id_member')->on('members')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction');
    }
};
