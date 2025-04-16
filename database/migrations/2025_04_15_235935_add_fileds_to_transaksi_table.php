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
        Schema::table('transaksi', function (Blueprint $table) {
            $table->integer('jumlah_bayar')->nullable();
            $table->integer('kembalian')->nullable();
            $table->enum('status', ['belum_bayar', 'lunas'])->default('belum_bayar')->change();
            $table->foreignId('kasir_id')->nullable()->constrained('users');
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            //
        });
    }
};
