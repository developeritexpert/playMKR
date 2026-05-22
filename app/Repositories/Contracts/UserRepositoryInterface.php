<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    public function create(array $data);
    public function findByEmail(string $email);
    public function updateByEmail(string $email, array $data);

    public function find($id);
    public function update($id, array $data);
}
