<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

/**
 * @class Authenticate
 * @description This middleware handles the authentication of the user and redirects them to the login page if they are not authenticated. 
 *              Additionally, it adjusts the session driver configuration for the registration route.
 */
class Authenticate extends Middleware
{
    /**
     * @function redirectTo
     * @description Determines the path to which the user should be redirected when they are not authenticated. 
     *              If the request does not expect a JSON response, it redirects to the login page.
     * @param \Illuminate\Http\Request $request
     * @return string|null
     * @route GET /login
     * @name login
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    /**
     * @function boot
     * @description Configures the session driver to use the 'array' driver for the 'register' route, 
     *              ensuring that sessions are not stored in a persistent manner during the registration process.
     */
    public function boot()
    {
        if (Request::is('register')) {
            Config::set('session.driver', 'array');
        }
    }
}
