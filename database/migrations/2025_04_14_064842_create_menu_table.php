<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration
{
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->string('nama');             // Nama menu
            $table->text('deskripsi')->nullable();  // Deskripsi makanan (opsional)
            $table->decimal('harga', 10, 2);      // Harga makanan
            $table->string('gambar')->nullable(); // Path ke gambar (opsional)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('menu');
    }
}
