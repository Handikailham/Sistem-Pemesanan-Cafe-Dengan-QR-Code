<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input login
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Coba login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
        
            logger("Login berhasil sebagai: " . $user->role);
        
            switch ($user->role) {
                case 'admin':
                    return redirect('/admin/meja');
                case 'kasir':
                    return redirect('/kasir');
                case 'dapur':
                    return redirect('/dapur');
                default:
                    Auth::logout();
                    return back()->withErrors(['email' => 'Role tidak dikenali.']);
            }
        }
        
        

        // Gagal login
        return back()->withErrors([
            'email' => 'Email atau password salah!',
        ]);
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
