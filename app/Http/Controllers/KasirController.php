<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller
{
    public function index()
    {
        return view('kasir.cari');
    }

    public function cari(Request $request)
{
    $transaksi = Transaksi::with('order.orderDetails.menu') // ini penting!
        ->where('kode_pembayaran', $request->kode_pembayaran)
        ->first();

    if (!$transaksi) {
        return redirect()->back()->with('error', 'Kode tidak ditemukan!');
    }

    return view('kasir.detail', compact('transaksi'));
}


public function bayar(Request $request, $id)
{
    $transaksi = Transaksi::with('order')->findOrFail($id);
    $totalTagihan = $transaksi->order->total();

    $jumlahBayar = $request->jumlah_dibayar;
    $kembalian   = $jumlahBayar - $totalTagihan;

    if ($kembalian < 0) {
        return back()->with('error', 'Jumlah bayar kurang dari total tagihan!');
    }

    // Update transaksi
    $transaksi->update([
        'jumlah_bayar'      => $jumlahBayar,
        'kembalian'         => $kembalian,
        'status'            => 'lunas',
        'kasir_id'          => Auth::id(),
    ]);

    // **Tutup order** setelah lunas
    $transaksi->order->update(['status' => 'closed']);

    return view('kasir.sukses', [
        'transaksi'     => $transaksi,
        'totalTagihan'  => $totalTagihan,
        'jumlah_bayar'  => $jumlahBayar,
        'kembalian'     => $kembalian,
    ]);
}

}
