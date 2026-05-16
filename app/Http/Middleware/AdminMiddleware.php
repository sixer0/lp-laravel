<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Ensure the request carries a valid admin session.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (empty(session('is_admin_logged_in'))) {
            return redirect('/admin/login');
        }

        return $next($request);
    }
}
