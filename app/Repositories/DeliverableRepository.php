<?php
namespace App\Repositories;

use App\Models\Deliverable;
use App\Repositories\Contracts\DeliverableRepositoryInterface;

class DeliverableRepository implements DeliverableRepositoryInterface
{
    public function paginate(int $perPage){
        return Deliverable::with(['deal', 'deliverType'])->latest()->paginate($perPage);
    }

    public function create(array $data){
        return Deliverable::create($data);
    }

    public function find(int $id){
        return Deliverable::with(['deal','deliverType'])->find($id);
    }

    public function update($deliverable, array $data){
        $deliverable->update($data);
        return $deliverable->fresh(['deal', 'deliverType']);
    }

    public function delete($deliverable){
        return $deliverable->delete();
    }
}