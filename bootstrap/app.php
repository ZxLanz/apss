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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(fn(Request $request) => route('welcome'));
        $middleware->redirectUsersTo(function (Request $request) {
            if ($request->is('portal-internal-smk-secure*')) {
                return route('admin.dashboard');
            }
            if ($request->is('siswa*')) {
                return route('siswa.dashboard');
            }
            return route('welcome');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
