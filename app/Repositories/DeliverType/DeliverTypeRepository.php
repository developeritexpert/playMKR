<?php

namespace App\Repositories\DeliverType;

use App\Models\DeliverType;

class DeliverTypeRepository
{
    public function paginate(int $perPage = 10)
    {
        return DeliverType::latest()->paginate($perPage);
    }

    public function findById($id)
    {
        return DeliverType::find($id);
    }

    public function create(array $data)
    {
        return DeliverType::create($data);
    }

    public function update($id, array $data)
    {
        $deliverType = DeliverType::find($id);

        if (!$deliverType) {
            return null;
        }

        $deliverType->update($data);

        return $deliverType;
    }

    public function delete($id)
    {
        $deliverType = DeliverType::find($id);

        if (!$deliverType) {
            return false;
        }

        $deliverType->delete();

        return true;
    }
}