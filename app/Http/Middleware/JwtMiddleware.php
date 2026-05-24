<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class JwtMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $cookieToken = $request->cookie('token');
        $bearerToken = $request->bearerToken();
        $token = $cookieToken ?: $bearerToken;

        if (!$token) {
            return response()->json([
                'message' => 'Unauthenticated.',
                'debug' => [
                    'cookie_name' => 'token',
                    'has_cookie' => $request->hasCookie('token'),
                    'has_bearer' => !empty($bearerToken),
                    'all_cookies' => array_keys($request->cookies->all()),
                ]
            ], 401);
        }

        // Inject the token into the Authorization header if it came from a cookie,
        // so the JWT guard can find it if needed later in the request.
        if ($cookieToken === $token) {
            $request->headers->set('Authorization', 'Bearer ' . $token);
        }

        try {
            // Use JWTAuth directly for more explicit control
            \PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth::setToken($token);
            $user = \PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth::authenticate();

            if (!$user) {
                return response()->json([
                    'message' => 'User not found.',
                    'debug' => 'Token was valid but user could not be retrieved.'
                ], 401);
            }

            // Set the user for the guard
            auth('api')->setUser($user);

        } catch (\PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json([
                'message' => 'Token has expired.',
                'error' => $e->getMessage(),
                'source' => $cookieToken ? 'cookie' : 'bearer'
            ], 401);
        } catch (\PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json([
                'message' => 'Token is invalid.',
                'error' => $e->getMessage(),
                'token_preview' => substr($token, 0, 15) . '...',
                'source' => $cookieToken ? 'cookie' : 'bearer'
            ], 401);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Authentication error: ' . $e->getMessage(),
                'trace' => $e->getFile() . ':' . $e->getLine(),
                'source' => $cookieToken ? 'cookie' : 'bearer'
            ], 401);
        }

        return $next($request);
    }
}
