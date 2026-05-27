<?php
namespace App\Repositories;

use App\Models\Deliverable;
use App\Models\DeliverableAttachment;
use App\Models\DeliverType;
use App\Repositories\Contracts\DeliverableRepositoryInterface;
use Illuminate\Support\Str;

class DeliverableRepository implements DeliverableRepositoryInterface
{
    public function paginate(int $perPage){
        return Deliverable::with([  'deal',
        'deliverType',
        'attachments',
        'assignedUser',
        'sponsor'])->latest()->paginate($perPage);
    }

    public function create(array $data){
        return Deliverable::create($data);
    }

    public function find(int $id){
        return Deliverable::with(['deal',
            'deliverType',
            'attachments',
            'assignedUser',
            'sponsor'])->find($id);
    }

    public function update($deliverable, array $data){
        $deliverable->update($data);
        return $deliverable->fresh(['deal',
            'deliverType',
            'attachments',
            'assignedUser',
            'sponsor']);
    }

    public function delete($deliverable){
        return $deliverable->delete();
    }

    public function createDeliverType(
        string $name
    ) {
        return DeliverType::firstOrCreate(
            [
                'slug' => Str::slug($name)
            ],
            [
                'name' => $name
            ]
        );
    }

    public function createAttachment(
        array $data
    ) {
        return DeliverableAttachment::create(
            $data
        );
    }
}