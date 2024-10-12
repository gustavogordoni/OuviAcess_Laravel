<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class GuestOrClientMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || (Auth::check() && Auth::user()->type == 2)) {
            return $next($request);
        }

        return redirect()->route('authentication')->withErrors(['error' => 'Acesso negado para administradores. Apenas clientes ou pessoas não autenticadas podem acessar esta página!']);
    }
}
