<?php

namespace App\Http\Controllers\Pelanggan;

use App\Models\Meja;
use App\Models\Menu;
use App\Models\Dapur;
use App\Models\Order;
use App\Models\Keranjang;
use App\Models\Transaksi;
use App\Models\OrderDetail;
use Illuminate\Support\Str;
use App\Events\PesananMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PesanController extends Controller
{
    // app/Http/Controllers/Pelanggan/PesanController.php
    public function index($nomor_meja)
    {
        $meja = Meja::where('nomor', $nomor_meja)->firstOrFail();
        $menu = Menu::all();
    
        // Ambil isi keranjang dan hitung jumlah + total
        $keranjangItems = Keranjang::with('menu')
            ->where('meja_id', $meja->id)
            ->get();
    
        $cartCount = $keranjangItems->sum('jumlah');
        $cartTotal = $keranjangItems->sum(fn($i) => $i->jumlah * $i->menu->harga);
    
        // Cek order pending
        $orderPending = Order::with('orderDetails')
            ->where('meja_id', $meja->id)
            ->where('status', 'pending')
            ->first();
    
        // HITUNG TAGIHAN SEBELUMNYA
        $previousTotal = 0;
        if ($orderPending) {
            $previousTotal = $orderPending->orderDetails
                ->sum(fn($d) => $d->quantity * $d->price);
        }
    
        return view('pelanggan.pesan', compact(
            'meja', 'menu',
            'keranjangItems', 'cartCount', 'cartTotal',
            'orderPending', 'previousTotal'    // <-- kirim ke view
        ));
    }
    


public function addToKeranjang(Request $request)
{
    $request->validate([
        'id'         => 'required|exists:menu,id',
        'nomor_meja' => 'required|exists:meja,nomor',
    ]);

    $meja = Meja::where('nomor', $request->nomor_meja)->firstOrFail();

    $existing = Keranjang::where('meja_id', $meja->id)
        ->where('menu_id', $request->id)
        ->first();

    if ($existing) {
        $existing->increment('jumlah', 1);
    } else {
        Keranjang::create([
            'meja_id' => $meja->id,
            'menu_id' => $request->id,
            'jumlah'  => 1, // default 1
        ]);
    }

    return redirect()->back()->with('success', 'Berhasil ditambahkan ke keranjang.');
}

public function tambahJumlah($menu_id, Request $request)
{
    $meja = Meja::where('nomor', $request->nomor_meja)->firstOrFail();

    $keranjang = Keranjang::where('meja_id', $meja->id)
                          ->where('menu_id', $menu_id)
                          ->first();

    if ($keranjang) {
        $keranjang->increment('jumlah');
    }

    return back();
}

public function kurangJumlah($menu_id, Request $request)
{
    $meja = Meja::where('nomor', $request->nomor_meja)->firstOrFail();

    $keranjang = Keranjang::where('meja_id', $meja->id)
                          ->where('menu_id', $menu_id)
                          ->first();

    if ($keranjang) {
        if ($keranjang->jumlah > 1) {
            $keranjang->decrement('jumlah');
        } else {
            $keranjang->delete(); // kalau tinggal 1, langsung hapus
        }
    }

    return back();
}



public function keranjang($nomor_meja)
{
    $meja = Meja::where('nomor', $nomor_meja)->firstOrFail();

    // Ambil isi keranjang
    $keranjang = Keranjang::with('menu')
                   ->where('meja_id', $meja->id)
                   ->get();

    // Cari order pending untuk meja tersebut
    $order = Order::with('orderDetails.menu')
                  ->where('meja_id', $meja->id)
                  ->where('status', 'pending')
                  ->first();

    // Hitung total tagihan sebelumnya (orderDetails di order pending, 
    // tanpa keranjang yang belum dikonfirmasi)
    $previousTotal = 0;
    if ($order) {
        $previousTotal = $order->orderDetails
            ->sum(function($detail) {
                return $detail->quantity * $detail->price;
            });
    }

    return view('pelanggan.keranjang', compact(
        'meja',
        'keranjang',
        'order',
        'previousTotal'   // <-- kirim variabel ini ke view
    ));
}


public function confirmOrder(Request $request)
    {
        $request->validate([
            'meja_id' => 'required|exists:meja,id',
        ]);

        $meja_id = $request->meja_id;

        DB::beginTransaction();
        try {
            // Cari order pending yang sudah ada
            $order = Order::where('meja_id', $meja_id)
                          ->where('status', 'pending')
                          ->first();

            // Jika tidak ada, buat order baru
            if (!$order) {
                $order = Order::create([
                    'meja_id' => $meja_id,
                    'status'  => 'pending',
                ]);
            }

            $keranjangItems = Keranjang::with('menu')->where('meja_id', $meja_id)->get();

            if ($keranjangItems->isEmpty()) {
                return redirect()->back()->with('error', 'Keranjang masih kosong.');
            }

            foreach ($keranjangItems as $item) {
                // Jika menu sudah pernah dipesan sebelumnya di order yang sama, tambah jumlahnya
                $existingDetail = OrderDetail::where('order_id', $order->id)
                    ->where('menu_id', $item->menu_id)
                    ->first();

                if ($existingDetail) {
                    $existingDetail->increment('quantity', $item->jumlah);
                } else {
                    OrderDetail::create([
                        'order_id' => $order->id,
                        'menu_id'  => $item->menu_id,
                        'quantity' => $item->jumlah,
                        'price'    => $item->menu->harga,
                        'catatan'  => $item->catatan,
                    ]);
                }

                // Masukkan pesanan ke bagian dapur
                $dapurEntry = Dapur::create([
                    'order_id' => $order->id,
                    'menu_id'  => $item->menu_id,
                    'meja_id'  => $meja_id,
                    'jumlah'   => $item->jumlah,
                    'status'   => 'menunggu',
                    'catatan'  => $item->catatan,
                ]);

                // Broadcast event PesananMasuk untuk pesanan baru ini
                event(new PesananMasuk($dapurEntry));
            }

            // Kosongkan keranjang setelah pesanan diproses
            Keranjang::where('meja_id', $meja_id)->delete();

            DB::commit();

            return redirect()->route('keranjang.index', ['nomor_meja' => Meja::find($meja_id)->nomor])
                             ->with('success', 'Pesanan berhasil dikirim ke dapur.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pesanan.');
        }
    }


public function closeBill(Request $request)
{
    $meja_id = $request->input('meja_id');

    // Cari order pending
    $order = Order::where('meja_id', $meja_id)
                  ->where('status', 'pending')
                  ->first();

    if (!$order) {
        return redirect()->back()->with('error', 'Order tidak ditemukan atau sudah ditutup.');
    }

    // **Jangan tutup di sini.** 
    // Cukup redirect ke form transaksi (bayar di kasir).
    return redirect()->route('pesan.transaksi', ['order_id' => $order->id]);
}


    public function status($nomor_meja)
    {
        $meja = Meja::where('nomor', $nomor_meja)->firstOrFail();

        $pesanan = Dapur::with('menu')
            ->where('meja_id', $meja->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pelanggan.status', compact('meja', 'pesanan'));
    }

    public function updateKeranjang(Request $request, $id)
    {
        $keranjang = Keranjang::findOrFail($id);

        $keranjang->jumlah = $request->input('jumlah');
        $keranjang->catatan = $request->input('catatan');
        $keranjang->save();

        return response()->json(['message' => 'Berhasil diupdate']);
    }

    public function showTransaksi($order_id)
{
    $order = Order::with('orderDetails.menu', 'meja')
                  ->findOrFail($order_id);

    if ($transaksi = Transaksi::where('order_id', $order_id)->first()) {
        return view('transaksi.show', compact('transaksi'));
    }

    $subTotal      = $order->orderDetails->sum(fn($d) => $d->quantity * $d->price);
    $serviceCharge = round($subTotal * 0.05);
    $pb1           = round($subTotal * 0.10);
    $grandTotal    = $subTotal + $serviceCharge + $pb1;
    $roundedTotal  = floor($grandTotal / 500) * 500;
    $roundingAmount = $grandTotal - $roundedTotal;
    $menuCount     = $order->orderDetails->count();

    return view('transaksi.create', compact(
        'order', 'subTotal', 'serviceCharge', 'pb1',
        'grandTotal', 'roundedTotal', 'roundingAmount', 'menuCount'
    ));
}




public function storeTransaksi(Request $request)
{
    $data = $request->validate([
        'order_id'          => 'required|exists:orders,id',
        'metode_pembayaran' => 'required|in:online,kasir',
        'total_transaksi'   => 'required|numeric|min:0',
    ]);

    // Generate kode pembayaran
    $data['kode_pembayaran'] = strtoupper(Str::random(8));
    $data['status']          = 'belum_bayar';

    // Simpan transaksi berikut totalnya
    $transaksi = Transaksi::create($data);

    // Redirect ke halaman detail transaksi
    return redirect()->route('pesan.transaksi', ['order_id' => $data['order_id']]);
}


    public function remove($id)
    {
        $item = Keranjang::find($id);
        if ($item) {
            $item->delete();
        }

        return response()->json(['success' => true]);
    }
}
