<?php

namespace App\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceModeMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Cache::get('maintenance_mode', false)) {
            // Allow admin users to bypass maintenance mode
            if ($request->user() && $request->user()->hasRole('admin')) {
                return $next($request);
            }

            // Allow API health check
            if ($request->is('up')) {
                return $next($request);
            }

            return response()->view('errors.503', [], 503);
        }

        return $next($request);
    }
}
