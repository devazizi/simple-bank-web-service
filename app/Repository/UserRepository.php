<?php

namespace App\Repository;

use App\Infrastructure\Interfaces\Repositories\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function get($id)
    {
        return User::query()->findOrFail($id);
    }
}
