<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();
        $path = $request->path();  // misal "dapur/orders"

        switch ($user->role) {
            case 'admin':
                // admin boleh akses di mana saja
                return $next($request);

            case 'kasir':
                // kalau URL-nya di prefix "kasir", lanjut
                if ($request->is('kasir*')) {
                    return $next($request);
                }
                // selain itu, redirect ke dashboard kasir
                return redirect()->route('kasir.index')
                                 ->with('error', 'Anda tidak memiliki akses ke halaman ini.');

            case 'dapur':
                // kalau URL-nya di prefix "dapur", lanjut
                if ($request->is('dapur*')) {
                    return $next($request);
                }
                // selain itu, redirect ke dashboard dapur
                return redirect()->route('dapur.index')
                                 ->with('error', 'Anda tidak memiliki akses ke halaman ini.');

            default:
                // role lain sama sekali nggak boleh
                abort(403, 'Role tidak dikenali.');
        }
    }
}
