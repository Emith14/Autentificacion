<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Class PreventSessionStart
 * Middleware that prevents the session from starting on the registration page.
 *
 * This middleware ensures that the session is not initialized for the 'register' route.
 * It clears the Laravel session to prevent unnecessary session data during the registration process.
 */
class PreventSessionStart
{
    /**
     * Handle an incoming request.
     *
     * This method checks if the current route is 'register' and, if so, it clears the session data
     * to prevent the session from being started unnecessarily during the registration process.
     *
     * @param  \Illuminate\Http\Request  $request The incoming HTTP request instance.
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next The next middleware to be executed.
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse The response after the middleware has completed.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the request is for the 'register' route
        if ($request->is('register')) {
            // Clear the session to prevent it from starting on the register route
            session()->forget('laravel_session');
        }

        // Proceed with the next middleware or the request itself
        return $next($request);
    }
}
