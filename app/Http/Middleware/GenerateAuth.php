<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GenerateAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->get('generate_authorized', false)) {
            return redirect()->route('generate.form');
        }

        return $next($request);
    }
}
