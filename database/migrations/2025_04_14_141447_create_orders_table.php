<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('meja_id');
            $table->string('status')->default('pending'); // misalnya: pending, confirmed, paid
            $table->decimal('total_harga', 10, 2)->nullable();
            $table->timestamps();

            // Jika ada relasi ke tabel 'mejas'
            $table->foreign('meja_id')->references('id')->on('meja')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
