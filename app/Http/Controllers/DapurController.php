<?php

namespace App\Http\Controllers;

use App\Models\Dapur;

class DapurController extends Controller
{
    public function index()
{
    $pesanan = Dapur::with(['menu', 'meja'])
        ->orderBy('created_at', 'desc')
        ->get()
        ->groupBy('meja.nomor'); // Kelompokkan berdasarkan nomor meja

    return view('dapur.index', compact('pesanan'));
}

public function prosesMeja($nomorMeja)
{
    // Ambil semua pesanan dari meja tersebut
    $items = Dapur::whereHas('meja', function ($query) use ($nomorMeja) {
        $query->where('nomor', $nomorMeja);
    })->get();

    // Hapus semua item dari meja itu
    foreach ($items as $item) {
        $item->delete();
    }

    return redirect()->back()->with('success', "Semua pesanan dari Meja #$nomorMeja telah diproses.");
}



    public function updateStatus($id)
    {
        $item = Dapur::findOrFail($id);
        $item->status = request('status'); // bisa "proses" atau "selesai"
        $item->save();

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }
}
