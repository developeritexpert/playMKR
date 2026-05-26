<?php

namespace App\Repositories\Contracts;

use App\Models\TicketManagement;

interface TicketRepositoryInterface
{
    public function paginate(int $perPage = 10);
    public function find(int $id);
    public function create(array $data);
    public function update(TicketManagement $ticket, array $data);
    public function delete(TicketManagement $ticket);
    public function getLastTicket();
}