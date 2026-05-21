<?php
namespace App\Repositories\Eloquent;

use App\Models\DealType;
use App\Repositories\Contracts\DealTypeRepositoryInterface;

class DealTypeRepository implements DealTypeRepositoryInterface
{
    public function all()
    {
        return DealType::all();
    }

    public function find(int $id)
    {
        return DealType::find($id);
    }

    public function create(array $data)
    {
        return DealType::create($data);
    }

    public function update(DealType $dealType, array $data)
    {
        $dealType->update($data);
        return $dealType;
    }

    public function delete(DealType $dealType)
    {
        return $dealType->delete();
    }
}