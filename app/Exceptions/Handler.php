<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($request->wantsJson() || $request->is('api/*')) {
            if ($e instanceof AuthorizationException) {
                return response()->json([
                    'success' => false,
                    'status' => Response::HTTP_FORBIDDEN,
                    'message' => 'Unauthenticated',
                ], Response::HTTP_FORBIDDEN);
            }

            if ($e instanceof AuthenticationException) {
                return response()->json([
                    'success' => false,
                    'status' => Response::HTTP_UNAUTHORIZED,
                    'message' => 'Unauthorized',
                ], Response::HTTP_UNAUTHORIZED);
            }
        }

        return parent::render($request, $e);
    }
}
