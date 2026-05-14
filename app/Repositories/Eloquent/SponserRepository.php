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
}