<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menu = Menu::all();
        return view('admin.menu.index', compact('menu'));
    }

    public function create()
    {
        return view('admin.menu.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nama' => 'required',
        'harga' => 'required|numeric',
        'kategori' => 'required',
        'deskripsi' => 'nullable|string',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $data = $request->only(['nama', 'harga', 'kategori', 'deskripsi']);

    if ($request->hasFile('gambar')) {
        $gambar = $request->file('gambar');
        $namaGambar = time() . '.' . $gambar->getClientOriginalExtension();
        $gambar->move(public_path('menu'), $namaGambar);
        $data['gambar'] = $namaGambar;
    }

    Menu::create($data);

    return redirect()->route('admin.menu.index')->with('success', 'Data menu berhasil ditambahkan.');
}



    public function show($id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin.menu.show', compact('menu'));
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin.menu.edit', compact('menu'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'nama' => 'required',
        'harga' => 'required|numeric',
        'kategori' => 'required',
        'deskripsi' => 'nullable|string',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Cari data menu yang akan diupdate
    $menu = Menu::findOrFail($id);

    // Ambil data yang baru
    $data = $request->only(['nama', 'harga', 'kategori', 'deskripsi']);

    // Cek jika ada file gambar yang diupload
    if ($request->hasFile('gambar')) {
        // Hapus gambar lama jika ada
        if ($menu->gambar && file_exists(public_path('menu/' . $menu->gambar))) {
            unlink(public_path('menu/' . $menu->gambar));
        }

        // Simpan gambar baru
        $gambar = $request->file('gambar');
        $namaGambar = time() . '.' . $gambar->getClientOriginalExtension();
        $gambar->move(public_path('menu'), $namaGambar);
        $data['gambar'] = $namaGambar;
    }

    // Update data menu
    $menu->update($data);

    return redirect()->route('admin.menu.index')->with('success', 'Data menu berhasil diperbarui.');
}



    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('admin.menu.index')->with('success', 'Data menu berhasil dihapus.');
    }
}
