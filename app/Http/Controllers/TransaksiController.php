<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function create(Request $request)
{
    $order_id = $request->query('order_id');
    $order = Order::with('keranjang')->find($order_id);

    if (!$order) {
        return redirect()->back()->with('error', 'Order tidak ditemukan.');
    }

    return view('transaksi.create', compact('order'));
}

}
