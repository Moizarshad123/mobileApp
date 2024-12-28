<?php

namespace App\Exceptions;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    
     protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function shouldReturnJson($request, Throwable $e)
    {
        if ($request->isJson()) {
            return true;
        } else {
            return false;
        }
    }

    public function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json([
                'status' => false,
                'message' => "Unauthorized",
                'data' => array(),
                'errors' => array()
            ], 401);

    }
}
