<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $session = session('authenticated_user');

        if (isset($session) && $session['message'] == 'login success') {
            return redirect()->route('posts.index');
        }
        if (isset($session) || $session == null) {
            return $next($request);
        }
        return $next($request);
    }
}
