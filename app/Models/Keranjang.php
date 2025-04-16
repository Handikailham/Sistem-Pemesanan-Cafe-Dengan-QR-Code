<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keranjang extends Model
{
    use HasFactory;

    protected $fillable = ['meja_id', 'menu_id', 'jumlah'];

    public function meja()
    {
        return $this->belongsTo(Meja::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
