<?php

use App\Exceptions\SistemException;
use App\Http\Middleware\CheckRestaurantAccess;
use App\Http\Middleware\ForceJsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Spatie\Permission\Exceptions\UnauthorizedException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->group('api', [
            ForceJsonResponse::class,
            SubstituteBindings::class,
        ]);

        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'check.restaurant' => CheckRestaurantAccess::class,
        ]);
      
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(
            function (SistemException $e, $request) {
                return response()->json([
                    'message' => $e->getMessage(),
                ], $e->status());
            }
        );
        $exceptions->renderable(
            function (UnauthorizedException $e, $request ) {
                return response()->json([
                    'message' => 'Você não tem permissão para acessar este recurso.',
                ], 403);
            }
        );
        
        $exceptions->render(function (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Recurso não encontrado.'
            ], 404);

        });

        $exceptions->render(function (QueryException $e, $request) {
            return response()->json([
                'message' => 'Erro interno.'
            ], 500);
        });
    })->create();