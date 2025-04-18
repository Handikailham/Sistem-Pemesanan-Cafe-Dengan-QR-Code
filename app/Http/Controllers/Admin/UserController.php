<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
{
    $users = User::orderBy('id', 'asc')->get(); // urutan dari yang lama ke yang baru
    return view('admin.user.index', compact('users'));
}


    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,kasir,dapur', // Tambah validasi
        ]);
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
        
        return redirect()->route('admin.user.index')
                         ->with('success','User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => "required|email|unique:users,email,{$id}",
        'password' => 'nullable|string|min:8|confirmed',
        'role'     => 'required|in:admin,kasir,dapur', // Tambahan validasi role
    ]);

    $user = User::findOrFail($id);
    $user->name  = $request->name;
    $user->email = $request->email;
    $user->role  = $request->role; // Simpan role

    if ($request->password) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->route('admin.user.index')
                     ->with('success','User berhasil diperbarui.');
}


    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.user.index')
                         ->with('success','User berhasil dihapus.');
    }
}
