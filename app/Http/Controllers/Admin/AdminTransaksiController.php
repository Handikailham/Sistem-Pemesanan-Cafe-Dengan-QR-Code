<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class AdminTransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with(['order.meja', 'order.orderDetails.menu'])->orderBy('created_at', 'asc')->get();
        return view('admin.transaksi.index', compact('transaksi'));
    }
}
