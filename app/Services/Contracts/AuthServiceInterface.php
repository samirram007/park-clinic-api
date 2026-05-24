<?php

namespace App\Services\Contracts;

use App\Models\User;
use Illuminate\Http\Request;

interface AuthServiceInterface
{
    /**
     * Attempt to authenticate a user and return the user and token if successful.
     *
     * @param array $credentials
     * @return array{user: User, token: string}|null
     */
    public function login(array $credentials): ?string;

    /**
     * Log the user out.
     */
    public function logout(): void;

    /**
     * Refresh the current token.
     *
     * @return string
     */
    public function refresh(): string;

    /**
     * Get the authenticated user.
     */
    public function user(): ?User;
}
