<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = ['order_id', 'menu_id', 'quantity', 'price'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relasi ke menu (opsional, jika sudah ada model Menu)
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
