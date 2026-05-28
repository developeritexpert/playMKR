<?php

namespace App\Repositories\Eloquent;

use App\Models\SponsorApplications;
use App\Models\Sponsor;
use App\Repositories\Contracts\SponsorRepositoryInterface;

class SponsorRepository implements SponsorRepositoryInterface
{
    public function addSponserApplicationRequest(array $data)
    {
        return SponsorApplications::create($data);
    }

    public function paginateApplications(array $filters = [], int $perPage = 10)
    {
        return SponsorApplications::filterAndSearch(
            $filters, 
            ['name', 'email', 'company_name', 'contact_number', 'industry'] 
        )->paginate($perPage);
    }

    public function getByStatus(string $status)
    {
        return SponsorApplications::where('status', $status)->get();
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
        return SponsorApplications::find($id);
    }
}
