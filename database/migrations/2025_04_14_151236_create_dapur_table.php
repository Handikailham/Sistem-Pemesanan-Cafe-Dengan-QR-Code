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
        Schema::create('dapur', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders');
            $table->foreignId('menu_id')->constrained('menu');
            $table->foreignId('meja_id')->constrained('meja');
            $table->integer('jumlah');
            $table->enum('status', ['menunggu', 'proses', 'selesai'])->default('menunggu');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dapur');
    }
};
