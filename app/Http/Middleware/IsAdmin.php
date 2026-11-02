<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user sudah login dan role_id nya 1
        if (Auth::check() && Auth::user()->role_id == '1') {
            return $next($request);
        }

        // Jika user bukan admin, maka akan menampilkan pesan kesalahan
        return redirect('/')->with('error', 'Akses ditolak.');
    }
}