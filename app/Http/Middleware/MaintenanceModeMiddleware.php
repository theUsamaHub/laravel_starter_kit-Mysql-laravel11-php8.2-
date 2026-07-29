<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceModeMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Setting::get('maintenance_mode', false)) {
            return $next($request);
        }

        // Allow health check
        if ($request->is('up', 'health')) {
            return $next($request);
        }

        // Allow auth routes so users can log in
        $bypassRoutes = Setting::get('maintenance_bypass_routes', 'login,register,forgot-password,reset-password*');
        $bypassPatterns = array_map('trim', explode(',', $bypassRoutes));
        foreach ($bypassPatterns as $pattern) {
            if ($request->is($pattern)) {
                return $next($request);
            }
        }

        // Allow admin users
        if ($request->user() && $request->user()->hasRole('admin')) {
            return $next($request);
        }

        $message = Setting::get('maintenance_message', 'We are currently performing scheduled maintenance. We will be back shortly.');

        return response()->view('errors.503', compact('message'), 503);
    }
}
