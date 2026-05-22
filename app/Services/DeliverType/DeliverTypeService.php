<?php

namespace App\Services\DeliverType;

use App\Repositories\DeliverType\DeliverTypeRepository;

class DeliverTypeService
{
    protected $deliverTypeRepo;

    public function __construct(DeliverTypeRepository $deliverTypeRepo)
    {
        $this->deliverTypeRepo = $deliverTypeRepo;
    }

    public function getAll()
    {
        return $this->deliverTypeRepo->getAll();
    }

    public function create(array $data)
    {
        return $this->deliverTypeRepo->create($data);
    }

    public function update($id, array $data)
    {
        return $this->deliverTypeRepo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->deliverTypeRepo->delete($id);
    }

    public function findById($id)
    {
        return $this->deliverTypeRepo->findById($id);
    }
}