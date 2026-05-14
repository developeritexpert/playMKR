<?php
namespace App\Repositories\Contracts;

use App\Models\Sponsor;

interface SponsorRepositoryInterface

{
    public function all();
    public function find(int $id);
    public function create(array $data);
    public function update(Sponsor $sponsor, array $data);
    public function delete(Sponsor $sponsor);
    public function paginate(int $perPage = 10);
}