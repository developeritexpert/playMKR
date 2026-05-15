<?php

namespace App\Repositories\Eloquent;

use App\Models\SponserApplications;
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

    public function getByStatus(string $status){
        return SponserApplications::where('status', $status)->get();
    }

    public function find(int $id)
    {
        return SponserApplications::find($id);
    }

    public function update($model, array $data)
    {
        $model->update($data);
        return $model;
    }

}