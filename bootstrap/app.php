<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'isAdmin' => \App\Http\Middleware\IsAdmin::class,
            'isMember' => \App\Http\Middleware\IsMember::class,
        ]);

        // Pengganti perubahan file vendor Authenticate.php di modul:
        // pengguna yang belum login diarahkan ke katalog dengan pesan error.
        $middleware->redirectGuestsTo(function (Request $request) {
            session()->flash('error', 'Akses ditolak, Anda belum login.');
            return route('member.index');
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
