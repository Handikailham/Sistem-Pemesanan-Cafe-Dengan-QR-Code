<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMejaTable extends Migration
{
    public function up()
    {
        Schema::create('meja', function (Blueprint $table) {
            $table->id();
            $table->string('nomor')->unique(); // Nomor atau identitas meja
            $table->string('qr_code')->unique(); // Kode unik untuk QR, bisa berupa string yang di-generate
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('meja');
    }
}
