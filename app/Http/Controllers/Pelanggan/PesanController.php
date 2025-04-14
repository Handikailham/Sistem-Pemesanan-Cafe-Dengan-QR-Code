<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Meja;
use App\Models\Menu;
use Illuminate\Http\Request;

class PesanController extends Controller
{
    public function index($nomor_meja)
    {
        // Ambil data meja berdasarkan nomor meja
        $meja = Meja::where('nomor', $nomor_meja)->firstOrFail();

        // Ambil semua menu yang tersedia
        $menu = Menu::all();

        // Kirim data meja dan menu ke view
        return view('pelanggan.pesan', compact('meja', 'menu'));
    }
}
