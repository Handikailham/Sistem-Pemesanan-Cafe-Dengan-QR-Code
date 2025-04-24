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
    $transaksi = Transaksi::with('order.orderDetails.menu')
        ->where('kode_pembayaran', $request->kode_pembayaran)
        ->first();

    if (!$transaksi) {
        return redirect()->back()->with('error', 'Kode tidak ditemukan!');
    }

    // Hitung komponen biaya dari order
    $order           = $transaksi->order;
    $subTotal        = $order->orderDetails->sum(fn($d)=> $d->quantity * $d->price);
    $serviceCharge   = round($subTotal * 0.05);
    $pb1             = round($subTotal * 0.10);
    $grandTotal      = $subTotal + $serviceCharge + $pb1;
    // Pembulatan ke 500 terdekat ke bawah
    $roundedTotal    = floor($grandTotal / 500) * 500;
    $roundingAmount  = $grandTotal - $roundedTotal;

    return view('kasir.detail', compact(
        'transaksi',
        'subTotal',
        'serviceCharge',
        'pb1',
        'roundedTotal',
        'roundingAmount'
    ));
}



public function bayar(Request $request, $id)
{
    $transaksi = Transaksi::with('order.orderDetails')->findOrFail($id);

    // Hitung komponen biaya sama seperti di detail
    $order           = $transaksi->order;
    $subTotal        = $order->orderDetails->sum(fn($d)=> $d->quantity * $d->price);
    $serviceCharge   = round($subTotal * 0.05);
    $pb1             = round($subTotal * 0.10);
    $grandTotal      = $subTotal + $serviceCharge + $pb1;
    $roundedTotal    = floor($grandTotal / 500) * 500;
    $roundingAmount  = $grandTotal - $roundedTotal;

    $jumlahBayar = $request->jumlah_dibayar;
    $kembalian   = $jumlahBayar - $roundedTotal;

    if ($kembalian < 0) {
        return back()->with('error', 'Jumlah bayar kurang dari total tagihan!');
    }

    // Update transaksi
    $transaksi->update([
        'jumlah_bayar' => $jumlahBayar,
        'kembalian'    => $kembalian,
        'status'       => 'lunas',
        'kasir_id'     => Auth::id(),
    ]);
    // Tutup order
    $transaksi->order->update(['status' => 'closed']);

    return view('kasir.sukses', [
        'transaksi'       => $transaksi,
        'subTotal'        => $subTotal,
        'serviceCharge'   => $serviceCharge,
        'pb1'             => $pb1,
        'roundedTotal'    => $roundedTotal,
        'roundingAmount'  => $roundingAmount,
        'jumlah_bayar'    => $jumlahBayar,
        'kembalian'       => $kembalian,
    ]);
}


}
