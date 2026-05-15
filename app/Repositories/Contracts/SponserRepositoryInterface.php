<?php

namespace App\Repositories\Contracts;

interface SponserRepositoryInterface
{
    public function addSponserApplicationRequest(array $data);
    public function getAllSponserApplications();
    public function find(int $id);
    public function update($model, array $data);
}
