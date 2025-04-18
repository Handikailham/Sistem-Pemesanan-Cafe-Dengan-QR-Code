<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn(['nama', 'no_hp', 'email']);
        });
    }

    public function down()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->string('nama');
            $table->string('no_hp');
            $table->string('email')->nullable();
        });
    }
};
