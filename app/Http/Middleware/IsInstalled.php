<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsInstalled
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $envPath = base_path('.env');
        if (! file_exists($envPath)) {
            return redirect(url('/').'/install');
        }

        return $next($request);
    }
}
