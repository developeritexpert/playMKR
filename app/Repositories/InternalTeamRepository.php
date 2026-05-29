<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\InternalTeamRepositoryInterface;

class InternalTeamRepository implements InternalTeamRepositoryInterface
{ 
    public function paginate(array $filters = [], int $perPage = 10){
        return User::where('role_id', 2)
        ->filterAndSearch($filters,['name', 'email'])->paginate($perPage);
    }

    public function find(int $id)
    {
        return User::where('role_id', 2)->find($id);
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function update($user, array $data)
    {
        $user->update($data);
        return $user->fresh();
    }

    public function delete($user)
    {
        return $user->delete();
    }
}