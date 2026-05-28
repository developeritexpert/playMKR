<?php
namespace App\Repositories;

use App\Models\Deal;
use App\Repositories\Contracts\DealRepositoryInterface;

class DealRepository implements DealRepositoryInterface
{
    public function paginate(array $filters = [], int $perPage = 10)
    {
        return Deal::with(['sponsor', 'dealType'])
            ->filterAndSearch($filters, ['id', 'deal_title', 'sponsor.name'])
            ->paginate($perPage);
    }
    public function all()
    {
        return Deal::all();
    }

    public function find(int $id)
    {
        return Deal::find($id);
    }

    public function create(array $data)
    {
        return Deal::create($data);
    }

    public function update(Deal $deal, array $data)
    {
        $deal->update($data);
        return $deal;
    }

    public function delete(Deal $deal)
    {
        return $deal->delete();
    }
}