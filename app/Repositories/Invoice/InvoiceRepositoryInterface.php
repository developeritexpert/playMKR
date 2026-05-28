<?php
namespace App\Repositories\Invoice;

interface InvoiceRepositoryInterface
{
    // public function getAll();
    public function paginate(array $filters = [], int $perPage = 10);
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}