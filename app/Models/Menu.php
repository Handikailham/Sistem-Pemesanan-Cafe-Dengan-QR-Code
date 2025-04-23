<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu'; // nama tabel tidak menggunakan "s"
    
    protected $fillable = [
        'nama',
        'deskripsi',
        'kategori',
        'harga',
        'gambar',
    ];
    
}
