<?php 

namespace App\Repositories\Contracts;

interface DeliverableRepositoryInterface
{
    // public function paginate(int $perPage);
    public function paginate(array $filters = [], int $perPage = 10);
    public function create(array $data);
    public function find(int $id);
    public function update($deliverable, array $data);
    public function delete($deliverable);

    public function createDeliverType(string $name);
    public function createAttachment(array $data);

    public function getLastDeliverable(); 

}