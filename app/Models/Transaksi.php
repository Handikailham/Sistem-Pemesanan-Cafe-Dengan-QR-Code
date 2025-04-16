<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    // Allow mass assignment for these attributes
    protected $fillable = [
        'order_id',
        'nama',
        'no_hp',
        'email',
        'metode_pembayaran',
        'kode_pembayaran',
        'status',
        'jumlah_bayar',
        'kembalian',
        'kasir_id',
    ];
    

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderDetails()
{
    return $this->hasMany(OrderDetail::class);
}

}
