<?php

namespace App\Repositories\Contracts;

use App\Models\Sponsor;

interface SponserRepositoryInterface
{
    public function addSponserApplicationRequest(array $data);
    public function getAllSponserApplications();
    public function find(int $id);
    public function getByStatus(string $status);

    public function all();
    public function create(array $data);
    public function update($model, array $data);
    public function delete($model);
    public function paginate(int $perPage = 10);
}
