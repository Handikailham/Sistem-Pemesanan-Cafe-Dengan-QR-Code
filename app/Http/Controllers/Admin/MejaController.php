<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meja;
use Illuminate\Http\Request;

class MejaController extends Controller
{
    public function index()
    {
        $meja = Meja::all();
        return view('admin.meja.index', compact('meja'));
    }

    public function create()
    {
        return view('admin.meja.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor' => 'required|unique:meja,nomor',
        ]);

        $nomor = $request->nomor;
        // Generate kode unik untuk QR, misalnya dengan fungsi PHP uniqid() atau generator lain
        $qrCodeUnique = uniqid('meja_');

        Meja::create([
            'nomor'   => $nomor,
            'qr_code' => $qrCodeUnique,
        ]);

        return redirect()->route('admin.meja.index')->with('success', 'Data meja berhasil ditambahkan.');
    }

    public function show($id)
    {
        // Jika diperlukan, tampilkan detail meja
        $meja = Meja::findOrFail($id);
        return view('admin.meja.show', compact('meja'));
    }

    public function edit($id)
    {
        $meja = Meja::findOrFail($id);
        return view('admin.meja.edit', compact('meja'));
    }

    public function update(Request $request, $id)
    {
        $meja = Meja::findOrFail($id);
        $request->validate([
            'nomor' => 'required|unique:meja,nomor,'.$id,
        ]);

        $meja->update([
            'nomor' => $request->nomor,
            // Opsional: update qr_code jika diperlukan, biasanya tetap sama
        ]);

        return redirect()->route('admin.meja.index')->with('success', 'Data meja berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $meja = Meja::findOrFail($id);
        $meja->delete();
        return redirect()->route('admin.meja.index')->with('success', 'Data meja berhasil dihapus.');
    }
}
