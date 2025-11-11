<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Helpers\ApiResponse;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->render(function (Throwable $exception, Request $request) {

            // Only for API calls
            if (!$request->expectsJson()) {
                return false;
            }

            // =========================
            // CUSTOM API ERROR HANDLING
            // =========================

            // Validation
            if ($exception instanceof ValidationException) {
                return ApiResponse::error(
                    "Validation failed",
                    "ValidationException",
                    $exception->errors(),
                    422
                );
            }

            // Authentication
            if ($exception instanceof AuthenticationException) {
                return ApiResponse::error(
                    "Unauthenticated",
                    "AuthenticationException",
                    null,
                    401
                );
            }

            // Model Not Found
            if ($exception instanceof ModelNotFoundException) {
                return ApiResponse::error(
                    "Resource not found",
                    "ModelNotFoundException",
                    null,
                    404
                );
            }

            // Route Not Found
            if ($exception instanceof NotFoundHttpException) {
                return ApiResponse::error(
                    "Resource not found",
                    "NotFoundHttpException",
                    null,
                    404
                );
            }

            // Method Not Allowed
            if ($exception instanceof MethodNotAllowedHttpException) {
                return ApiResponse::error(
                    "Method not allowed",
                    "MethodNotAllowedHttpException",
                    null,
                    405
                );
            }

            // Query Exception
            if ($exception instanceof \Illuminate\Database\QueryException) {
                return ApiResponse::error(
                    "Database error",
                    "QueryException",
                    $exception->getMessage(),
                    500
                );
            }

            // Default fallback
            $status = ($exception instanceof HttpException)
                ? $exception->getStatusCode()
                : 500;

            return ApiResponse::error(
                $exception->getMessage() ?: "Server error",
                class_basename($exception),
                null,
                $status
            );
        });

    })->create();

