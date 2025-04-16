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
        Schema::create('transaksi', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('order_id');
        $table->string('nama');
        $table->string('no_hp');
        $table->string('email')->nullable();
        $table->string('metode_pembayaran'); // online / kasir
        $table->string('kode_pembayaran')->unique();
        $table->enum('status', ['belum_bayar', 'sudah_bayar'])->default('belum_bayar');
        $table->timestamps();
        $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
