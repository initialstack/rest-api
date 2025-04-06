<?php declare(strict_types=1);

use App\Services\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Illuminate\Http\{Request, Response};
use Illuminate\Routing\Middleware\SubstituteBindings;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Responses\MessageResponse;
use Illuminate\Http\Middleware\HandleCors;
use App\Middlewares\ApiRequestLogger;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [HandleCors::class]);
        $middleware->appendToGroup(
            group: 'api',
            middleware: [
                SubstituteBindings::class,
                ApiRequestLogger::class,
            ]
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(
            using: function (JWTException $e, Request $request) {
                Context::add(key: 'request_id', value: Str::uuid()->toString());
                Context::add(key: 'timestamp', value: now()->toIso8601String());
                
                return new MessageResponse(
                    message: $e->getMessage(),
                    status: Response::HTTP_UNAUTHORIZED
                );
            }
        );

        $exceptions->render(
            using: function (RouteNotFoundException $e, Request $request) {
                Context::add(key: 'request_id', value: Str::uuid()->toString());
                Context::add(key: 'timestamp', value: now()->toIso8601String());

                return new MessageResponse(
                    message: __('Unauthorized'),
                    status: Response::HTTP_UNAUTHORIZED
                );
            }
        );
        
        $exceptions->level(
            type: \PDOException::class,
            level: \Psr\Log\LogLevel::CRITICAL
        );
    })->create();
