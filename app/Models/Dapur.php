<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dapur extends Model
{
    use HasFactory;

    protected $table = 'dapur'; // Nama tabel jika tidak mengikuti konvensi Laravel

    protected $fillable = [
        'order_id',
        'menu_id',
        'meja_id',
        'jumlah',
        'status',
        'catatan',
    ];

    // Menentukan relasi dengan model lain jika diperlukan
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function meja()
    {
        return $this->belongsTo(Meja::class);
    }
}
