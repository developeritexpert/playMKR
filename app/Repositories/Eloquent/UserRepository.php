<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function create(array $data)
    {
        return User::create($data);
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function updateByEmail(string $email, array $data)
    {
        $user = User::where('email', $email)->first();
        if (!$user) return null;
        $user->update($data);
        return $user;
    }

    public function find($id)
    {
        return User::find($id);
    }

    public function update($id, array $data)
    {
        $user = User::find($id);
        if(!$user) return null;
        $user->update($data);
        return $user;
    }
}
