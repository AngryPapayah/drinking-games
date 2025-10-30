<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// ← ontbrak
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Gebruik duidelijke 403 (geen 404) zodat je weet dat het een rechten-issue is
        if (!Auth::check() || (int)Auth::user()->role_id !== 1) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
