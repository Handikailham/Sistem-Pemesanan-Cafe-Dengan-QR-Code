<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        if ($user->role !== 'admin') {
            switch ($user->role) {
                case 'kasir':
                    return redirect('/kasir')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
                case 'dapur':
                    return redirect('/dapur')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
                default:
                    return redirect('/')->with('error', 'Role tidak dikenali.');
            }
        }

        return $next($request);
    }
}
