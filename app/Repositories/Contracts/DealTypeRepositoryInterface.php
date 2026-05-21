<?php
namespace App\Repositories\Contracts;

use App\Models\DealType;

interface DealTypeRepositoryInterface
{
    public function all();
    public function find(int $id);
    public function create(array $data);
    public function update(DealType $dealType, array $data);
    public function delete(DealType $dealType);
}