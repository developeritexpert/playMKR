<?php
namespace App\Repositories;

use App\Models\Sponsor;
use App\Repositories\Contracts\SponsorRepositoryInterface;

class SponsorRepository implements SponsorRepositoryInterface
{
    public function paginate($perPage = 10)
    {
    return Sponsor::latest()->paginate($perPage);
    }

    public function all()
    {
        return Sponsor::all();
    }

    public function find(int $id)
    {
        return Sponsor::find($id);
    }

    public function create(array $data)
    {
        return Sponsor::create($data);
    }

    public function update(Sponsor $sponsor, array $data)
    {
        $sponsor->update($data);
        return $sponsor;
    }

    public function delete(Sponsor $sponsor)
    {
        return $sponsor->delete();
    }
}