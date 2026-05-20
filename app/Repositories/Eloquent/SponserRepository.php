<?php

namespace App\Repositories\Eloquent;

use App\Models\SponserApplications;
use App\Models\Sponsor;
use App\Repositories\Contracts\SponserRepositoryInterface;

class SponserRepository implements SponserRepositoryInterface
{
    public function addSponserApplicationRequest(array $data)
    {
        return SponserApplications::create($data);
    }

    public function getAllSponserApplications()
    {
        return SponserApplications::all();
    }

    public function getByStatus(string $status)
    {
        return SponserApplications::where('status', $status)->get();
    }

    public function find(int $id)
    {
        return Sponsor::find($id);
    }

    public function update($model, array $data)
    {
        $model->update($data);

        return $model->fresh();
    }

    public function paginate($perPage = 10)
    {
        return Sponsor::latest()->paginate($perPage);
    }

    public function all()
    {
        return Sponsor::all();
    }

    public function create(array $data)
    {
        return Sponsor::create($data);
    }

    public function delete($model)
    {
        return $model->delete();
    }

    public function findApplicationById(int $id)
    {
        return SponserApplications::find($id);
    }
}
