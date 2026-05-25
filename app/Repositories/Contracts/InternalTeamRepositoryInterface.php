<?php

namespace App\Repositories\Contracts;

interface InternalTeamRepositoryInterface
{
    public function paginate(int $perPage = 10);
    public function find(int $id);
    public function create(array $data);
    public function update($user, array $data);
    public function delete($user);
}