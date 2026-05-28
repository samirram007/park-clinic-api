<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\Contracts\AuthServiceInterface;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cookie;
use Exception;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    protected $domain;
    protected $token_expire_duration;
    public function __construct(
        protected AuthServiceInterface $authService,
        protected UserServiceInterface $userService
    ) {
        $this->domain = strtolower(config('session.domain'));
        // $this->token_expire_duration = env('TOKEN_EXPIRE_DURATION', 30000);
        $this->token_expire_duration = config('session.lifetime') * 60;
    }
    public function login(LoginRequest $request): JsonResponse
    {
        $token = $this->authService->login($request->validated());
        Log::info('Login token generated', ['token' => $token]);
        return $this->respondWithToken($token, 'Login successful!');

    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();

        // Expire the cookie by setting it to the past
        $cookie = cookie(
            'token',
            '',
            -60, // Expire 60 minutes in the past
            '/',
            $this->domain,
            true,
            true,
            true,
            'None'
        );

        return response()->json(
            [
                'message' => 'Logout successful',
                'expires_in' => config('jwt.ttl') * 60,
                'token' => ''
            ]
        )
            ->withCookie($cookie);
    }

    public function refresh(): JsonResponse
    {
        try {
            $token = $this->authService->refresh();

            $cookie = cookie(
                'token',
                $token,
                $this->token_expire_duration,
                '/',
                $this->domain,
                true,
                true,
                true,
                'None'
            );

            return response()->json([
                'message' => 'Token refreshed',
                'expires_in' => config('jwt.ttl') * 60
            ])->withCookie($cookie);
        } catch (Exception $e) {
            return response()->json(['message' => 'Could not refresh token'], 401);
        }
    }

    public function user(): JsonResponse
    {
        //return response()->json(['user' => $this->authService->user()]);
        return response()->json([
            'status' => 'success',
            'message' => 'User profile fetched successfully.',
            'data' => new UserResource($this->authService->user()),
        ]);
    }

    protected function respondWithToken(string $token, string $message = 'Authenticated successfully!')
    {

        $cookie = cookie(
            'token',
            $token,
            $this->token_expire_duration,
            '/',
            $this->domain,
            true,
            true,
            true,
            'None'
        );
        Log::info(' cookie', ['cookie' => $cookie]);

        return response()->json([
            'token' => $token,
            'tokenType' => 'bearer',
            'expiresIn' => config('jwt.ttl') * 60,
            'success' => true,
            'status' => 'success',
            'message' => $message,
        ])->withCookie($cookie);
    }
}
