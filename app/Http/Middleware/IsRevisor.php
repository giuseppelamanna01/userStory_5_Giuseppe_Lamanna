<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsRevisor
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->is_revisor) {
            return $next($request);
        }
        return redirect()->route('home')->with('errorMessage', 'Zona riservata ai revisori');
    }
}