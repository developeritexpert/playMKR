<?php
namespace App\Repositories\Contracts;

use App\Models\Deal;

interface DealRepositoryInterface
{
    public function all();
    public function find(int $id);
    public function create(array $data);
    public function update(Deal $deal, array $data);
    public function delete(Deal $deal);
    public function paginate(int $perPage = 10);

}