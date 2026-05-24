<?php
namespace App\Services;

use App\Models\User;
use App\Services\Contracts\UserServiceInterface;


class UserService implements UserServiceInterface
{
    public function getUserById(int $id)
    {
        return User::find($id);
    }
}
