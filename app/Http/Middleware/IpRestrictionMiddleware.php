<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IpRestrictionMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $whitelist = Setting::get('ip_whitelist', []);

        if (empty($whitelist)) {
            return $next($request);
        }

        $ip = $request->ip();

        foreach ($whitelist as $allowed) {
            if ($this->ipMatches($ip, $allowed)) {
                return $next($request);
            }
        }

        abort(403, 'Access denied: IP not whitelisted.');
    }

    private function ipMatches(string $ip, string $rule): bool
    {
        if (str_contains($rule, '*')) {
            $pattern = '/^' . str_replace('\*', '\d{1,3}', preg_quote($rule, '/')) . '$/';
            return (bool) preg_match($pattern, $ip);
        }

        if (str_contains($rule, '/')) {
            [$subnet, $bits] = explode('/', $rule);
            if (filter_var($subnet, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === false) {
                return $ip === $rule;
            }
            $ipLong = ip2long($ip);
            $subnetLong = ip2long($subnet);
            $mask = -1 << (32 - (int) $bits);
            return ($ipLong & $mask) === ($subnetLong & $mask);
        }

        return $ip === $rule;
    }
}
