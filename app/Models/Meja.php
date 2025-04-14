<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    use HasFactory;

    protected $table = 'meja'; // nama tabel tidak menggunakan "s"
    
    protected $fillable = [
        'nomor',
        'qr_code',
    ];
}
