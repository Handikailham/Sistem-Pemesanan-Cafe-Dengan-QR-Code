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
    public function index($nomor_meja)
    {
        $meja = Meja::where('nomor', $nomor_meja)->firstOrFail();
        $menu = Menu::all();
        return view('pelanggan.pesan', compact('meja', 'menu'));
    }

    public function addToKeranjang(Request $request)
    {
        $request->validate([
            'id'           => 'required|exists:menu,id',
            'quantity'     => 'required|integer|min:1',
            'nomor_meja'   => 'required|exists:meja,nomor',
        ]);

        $meja = Meja::where('nomor', $request->nomor_meja)->firstOrFail();

        $existing = Keranjang::where('meja_id', $meja->id)
            ->where('menu_id', $request->id)
            ->first();

        if ($existing) {
            $existing->increment('jumlah', $request->quantity);
        } else {
            Keranjang::create([
                'meja_id' => $meja->id,
                'menu_id' => $request->id,
                'jumlah'  => $request->quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Berhasil ditambahkan ke keranjang.');
    }

    public function keranjang($nomor_meja)
{
    $meja = Meja::where('nomor', $nomor_meja)->firstOrFail();
    $keranjang = Keranjang::with('menu')->where('meja_id', $meja->id)->get();
    // Mencari order pending untuk meja tersebut (jika ada)
    $order = Order::where('meja_id', $meja->id)->where('status', 'pending')->first();
    
    return view('pelanggan.keranjang', compact('meja', 'keranjang', 'order'));
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

    // Cari order pending untuk meja tersebut
    $order = Order::where('meja_id', $meja_id)
                  ->where('status', 'pending')
                  ->first();

    if (!$order) {
        return redirect()->back()->with('error', 'Order tidak ditemukan atau sudah ditutup.');
    }

    // Tutup order dengan mengganti status menjadi closed
    $order->status = 'closed';
    $order->save();

    return redirect()->route('transaksi.create', ['order_id' => $order->id]);
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
        $order = Order::with('orderDetails.menu')->findOrFail($order_id);
        $transaksi = Transaksi::where('order_id', $order_id)->first();
        return view('transaksi.form', compact('order', 'transaksi'));
    }

    public function storeTransaksi(Request $request)
    {
        $request->validate([
            'order_id'           => 'required|exists:orders,id',
            'nama'               => 'required',
            'no_hp'              => 'required',
            'email'              => 'nullable|email',
            'metode_pembayaran'  => 'required|in:online,kasir',
        ]);

        // Generate kode pembayaran
        $kode_pembayaran = strtoupper(Str::random(8));

        // Membuat transaksi baru
        $transaksi = Transaksi::create([
            'order_id'          => $request->order_id,
            'nama'              => $request->nama,
            'no_hp'             => $request->no_hp,
            'email'             => $request->email,
            'metode_pembayaran' => $request->metode_pembayaran,
            'kode_pembayaran'   => $kode_pembayaran,
            'status'            => 'belum_bayar',
        ]);

        $order = Order::with('meja')->findOrFail($request->order_id);
        return view('transaksi.form', compact('order', 'transaksi'));
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
