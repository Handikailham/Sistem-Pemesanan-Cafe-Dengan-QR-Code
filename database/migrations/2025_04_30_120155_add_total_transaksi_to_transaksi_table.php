<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalTransaksiToTransaksiTable extends Migration
{
    public function up()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            // ganti after('status') jika ingin di posisi lain
            $table->decimal('total_transaksi', 15, 2)
                  ->after('updated_at')
                  ->default(0);
        });
    }

    public function down()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn('total_transaksi');
        });
    }
}
