<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseFoundation;
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

    public function render($request, Throwable $e): Response|JsonResponse|ResponseFoundation|RedirectResponse
    {
        $middlewares = $request->route()?->middleware();

        if ($middlewares) {
            if (in_array('api', $middlewares)) {
                return response()->json([
                    'status' => $e->getCode() ?: 500,
                    'message' => $e->getMessage(),
                ], $e->getCode() ?: 500);
            }
        }

        return parent::render($request, $e);
    }
}
