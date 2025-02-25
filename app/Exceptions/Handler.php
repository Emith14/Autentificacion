<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Session\TokenMismatchException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    
    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        //Handle validation errors
        if ($exception instanceof ValidationException) {
            return redirect()->back()->withErrors($exception->errors())->withInput();
        }

        // Handle database connection errors
        if ($exception instanceof QueryException) {
            return redirect()->back()->with('error', 'Your request cannot be made at this time. Please try again later.');
        }

         // Handle 404 errors
         if ($exception instanceof NotFoundHttpException) {
            return response()->view('errors.error404', [], 404);
        }

        // Handle 419 Token Mismatch (CSRF Token Expired)
        if ($exception instanceof TokenMismatchException) {
            return redirect()->route('login')->with('error', 'Your session has expired. Please log in again.');
        }
         // Default behavior: pass the exception to Laravel's default handler
        return parent::render($request, $exception);
    }

}
