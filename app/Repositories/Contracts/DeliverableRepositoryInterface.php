<?php 

namespace App\Repositories\Contracts;

interface DeliverableRepositoryInterface
{
    public function paginate(int $perPage);
    public function create(array $data);
    public function find(int $id);
    public function update($deliverable, array $data);
    public function delete($deliverable);
}