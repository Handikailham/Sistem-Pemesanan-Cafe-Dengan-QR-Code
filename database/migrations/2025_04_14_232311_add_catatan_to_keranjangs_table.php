<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCatatanToKeranjangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('keranjangs', function (Blueprint $table) {
            $table->string('catatan')->nullable()->after('jumlah');  // Menambahkan kolom catatan setelah kolom jumlah
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('keranjangs', function (Blueprint $table) {
            $table->dropColumn('catatan');  // Menghapus kolom catatan jika migrasi di-revert
        });
    }
}
