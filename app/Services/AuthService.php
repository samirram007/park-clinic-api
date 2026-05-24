<?php

namespace App\Services;

use App\Models\User;
use App\Services\Contracts\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService implements AuthServiceInterface
{
    public function login(array $credentials): string
    {
        $token = Auth::attempt($credentials);

        if (!$token) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Mark as password login (optional, for analytics)
        $user = Auth::user();
        if ($user instanceof User) {
            $user->update(['provider' => 'password']);
        }

        return $token;
    }

    public function logout(): void
    {
        try {
            \PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth::invalidate(\PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth::getToken());
        } catch (\Exception $e) {
            // Token might already be invalid, which is fine
        }
        
        Auth::logout();
    }

    public function refresh(): string
    {
        return Auth::refresh();
    }

    public function user(): ?User
    {
        return Auth::guard('api')->user();
    }
}
