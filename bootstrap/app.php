<?php

use App\Helpers\ApiErrorResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // $middleware->encryptCookies(except: [
        //     'token',
        // ]);
        $middleware->use([
            App\Http\Middleware\NormalizeRequestKeys::class,
            App\Http\Middleware\NormalizeQueryParameters::class,
            Illuminate\Http\Middleware\HandleCors::class
        ]);
        // $middleware->alias([
        //     'jwt.auth' => \App\Http\Middleware\JwtMiddleware::class,
        // ]);
        $middleware->alias([
            'jwt.cookies' => App\Http\Middleware\JWTFromCookie::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->render(function (AuthenticationException $e) {
            if (request()->is('api/*')) {
                return ApiErrorResponse::respond(
                    'Unauthenticated.',
                    401,
                    null,
                    'AUTH_401'
                );
            }
        });

        $exceptions->render(function (AuthorizationException $e) {
            if (request()->is('api/*')) {
                return ApiErrorResponse::respond(
                    'This action is unauthorized.',
                    403,
                    null,
                    'AUTH_403'
                );
            }
        });
        $exceptions->render(function (ModelNotFoundException $e, $request) {
            if ($request->is('api/*')) {
                return ApiErrorResponse::respond(
                    'Resource not found.',
                    404,
                    null,
                    'RESOURCE_NOT_FOUND'
                );
            }
        });
        $exceptions->render(function (NotFoundHttpException $e, $request) {

            if ($request->is('api/*')) {
                $previous = $e->getPrevious();

                if ($previous instanceof ModelNotFoundException) {
                    return ApiErrorResponse::respond(
                        'Resource not found.',
                        404,
                        null,
                        'RESOURCE_NOT_FOUND',
                        config('app.debug') ? ['message' => $e->getMessage()] : null
                    );
                }

                return ApiErrorResponse::respond(
                    'URL not found.',
                    404,
                    null,
                    'ROUTE_NOT_FOUND',
                    config('app.debug') ? ['message' => $e->getMessage()] : null
                );
            }
        });

        $exceptions->render(function (ValidationException $e) {
            if (request()->is('api/*')) {
                $errors = collect($e->errors())->mapWithKeys(function ($messages, $key) {
                    // Flatten key: take only the last segment
                    $flatKey = last(explode('.', $key));

                    // Clean messages: remove any prefix like 'address.' or 'billing.'
                    $cleanMessages = array_map(function ($msg) use ($key) {
                        // Remove everything before the field name (last segment)
                        $fieldName = last(explode('.', $key));
                        return preg_replace('/.*' . preg_quote($fieldName, '/') . '/', $fieldName, $msg);
                    }, $messages);

                    return [$flatKey => $cleanMessages];
                })->toArray();



                return ApiErrorResponse::respond(
                    'Validation failed.',
                    422,
                    $errors,
                    'VALIDATION_ERROR'
                );
            }
        });

        $exceptions->render(function (InvalidArgumentException $e, $request) {
            //dd($request->all());
            if ($request->is('api/*')) {
                return ApiErrorResponse::respond(
                    'Invalid parameter.',
                    400,
                    null,
                    'INVALID_PARAMETER',
                    config('app.debug') ? ['message' => $e->getMessage()] : null
                );
            }
        });


        $exceptions->render(function (Throwable $e) {

            if (request()->is('api/*')) {
                $debug = null;
                $message = $e->getMessage() ?: 'Internal server error.';

                if (config('app.debug')) {
                    $debug = [
                        'message' => $e->getMessage(),
                        'exception' => get_class($e),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'trace' => collect($e->getTrace())->take(5)->toArray(),
                    ];
                } else {
                    // In production, hide the message if it's not a HttpException
                    if (!$e instanceof Symfony\Component\HttpKernel\Exception\HttpExceptionInterface) {
                        $message = 'Internal server error.';
                    }
                }

                return ApiErrorResponse::respond(
                    $message,
                    (int) $e->getCode() ?: 500,
                    null,
                    'INTERNAL_ERROR',
                    $debug
                );
            }
        });
    })->create();
