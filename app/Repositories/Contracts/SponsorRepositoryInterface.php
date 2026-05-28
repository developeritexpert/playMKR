<?php

namespace App\Repositories\Contracts;

interface SponsorRepositoryInterface
{
    public function addSponserApplicationRequest(array $data);
    public function paginateApplications(array $filters = [], int $perPage = 10);

    public function find(int $id);
    public function getByStatus(string $status);

    public function all();
    public function create(array $data);
    public function update($model, array $data);
    public function delete($model);
    public function paginate(int $perPage = 10);
    public function findApplicationById(int $id);
}
