<?php

use App\Exceptions\Address\AddressErrorException;
use App\Http\Middleware\PreventAdminAssignmentMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->group('api', [
            EnsureFrontendRequestsAreStateful::class,
        ]);
        $middleware->append(PreventAdminAssignmentMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(
            function (AddressErrorException $e, $request) {
                return response()->json([
                    'message' => $e->getMessage(),
                ], $e->getCode());
            }
        );
    })->create();
