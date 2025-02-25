<?php

use App\Http\Controllers\User\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\RegisterController;
use Illuminate\Support\Facades\DB;
/*
|---------------------------------------------------------------------------
| Web Routes
|---------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group that contains
| the "web" middleware group. Now create something great!
|
*/

/**
 * @route GET /
 * @name /
 * @description Redirects to the registration page.
 */
Route::get('/', function () {
    return redirect()->route('register'); 
});


/**
 * @route GET /welcome
 * @name welcome
 * @description Displays the welcome page.
 * @middleware checkCookie
 */
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome')->middleware('checkCookie');

/**
 * @route GET /register
 * @name register
 * @description Displays the registration page.
 * @middleware preventSessionStart
 */
Route::get('/register', function () {
    return view('register');
})->name('register')->middleware('preventSessionStart');

/**
 * @route POST /register
 * @name register.store
 * @description Handles the user registration request.
 * @middleware preventSessionStart
 */
Route::post('/register', [RegisterController::class, 'store'])
    ->name('register.store')->middleware('preventSessionStart');



/**
 * @route GET /login
 * @name login
 * @description Displays the login page.
 */
Route::get('/login', function () {
    return view('login');
})->name('login');



// Group of routes for user authentication
Route::group(['prefix' => 'auth'], function() {

    /**
     * @route GET /auth/activation/{user}
     * @name activation
     * @description Displays the user activation page.
     */
    Route::get('/activation/{user}', [RegisterController::class, 'activation'])
        ->name('activation');
    
    /**
     * @route GET /auth/activation/error
     * @name activation.error
     * @description Displays the activation error page.
     */
    Route::get('/activation/error', function () {
        return view('mails.activationerror');
    })->name('activation.error');

    /**
     * @route GET /auth/activate/{user}
     * @name activate
     * @description Activates the user account with a signed URL.
     * @middleware signed
     */
    Route::get('/activate/{user}', [RegisterController::class, 'activate'])
        ->name('activate')
        ->middleware('signed');

    /**
     * @route POST /auth/login
     * @name login.post
     * @description Handles the user login request.
     */
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    /**
     * @route POST /auth/verify-2fa
     * @name 2fa.verify
     * @description Verifies the 2FA code entered by the user.
     */
    Route::post('/verify-2fa', [LoginController::class, 'verify2FACode'])->name('2fa.verify');

    /**
     * @route POST /auth/logout
     * @name logout
     * @description Logs out the user.
     */
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    /**
     * @route GET /auth/activate/{user}
     * @name activate
     * @description Activates the user account with a signed URL.
     * @middleware signed
     */
    Route::get('/activate/{user}', [LoginController::class, 'activate'])
        ->name('activate')
        ->middleware('signed');

    /**
     * @route GET /auth/access/activation/{user}
     * @name access.activation
     * @description Displays the user access activation page.
     */
    Route::get('/access/activation/{user}', function ($user) {
        return view('activation', compact('user'));
    })->name('access.activation');

    /**
     * @route GET /auth/verifycode
     * @name 2fa.view
     * @description Displays the 2FA verification code page.
     */
    Route::get('/verifycode', function () {
        return view('twofactorcode');
    })->name('2fa.view');
});


