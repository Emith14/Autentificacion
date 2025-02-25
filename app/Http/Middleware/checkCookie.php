<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Middleware to check if the user is authenticated and prevent caching.
 *
 * This middleware ensures that the user is authenticated before proceeding with the request.
 * It also prevents the caching of responses by setting appropriate headers to avoid storing sensitive data.
 */
class CheckCookie
{
    /**
     * Handle an incoming request.
     *
     * This method checks if the user is authenticated. If the user is not authenticated, 
     * they are redirected to the login page with an error message.
     * Additionally, it sets response headers to prevent caching of sensitive data.
     *
     * @param  \Illuminate\Http\Request  $request  The incoming HTTP request instance.
     * @param  \Closure  $next  The next middleware to be executed.
     * @return mixed The HTTP response, either redirecting or allowing the request to proceed.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            // Redirect to the login page if not authenticated
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        // Get the response of the request
        $response = $next($request);

        // Set headers to prevent caching of sensitive data
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Thu, 01 Jan 1970 00:00:00 GMT');

        return $response;
    }
}
