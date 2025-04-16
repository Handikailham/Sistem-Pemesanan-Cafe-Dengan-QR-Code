<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['meja_id', 'status', 'total_harga'];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    // Relasi ke meja (opsional, jika sudah ada model Meja)
    public function meja()
    {
        return $this->belongsTo(Meja::class);
    }

    public function transaksi()
{
    return $this->hasOne(Transaksi::class);
}

public function total()
{
    return $this->orderDetails->sum(function ($detail) {
        return $detail->quantity * $detail->price;
    });
}


}
