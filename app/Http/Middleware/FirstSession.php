<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Auth;
use Closure;

class FirstSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user_status = Auth::user()->status;
            if ($user_status == 'pending') {
                return redirect('start');
            }

            return $next($request);
        }
    }
}
