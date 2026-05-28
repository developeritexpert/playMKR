<?php

namespace App\Repositories;

use App\Models\TicketManagement;
use App\Repositories\Contracts\TicketRepositoryInterface;

class TicketRepository implements TicketRepositoryInterface
{
    public function paginate(array $filters = [], int $perPage = 10)
    {
        return TicketManagement::with(['deal', 'sponsor', 'assignedUser', 'assignedBy'])
            ->filterAndSearch($filters, ['ticket_id', 'ticket_name', 'deal.deal_title', 'sponsor.name'])
            ->paginate($perPage);
    }

    public function find(int $id){
        return TicketManagement::with(['deal','sponsor','assignedUser','assignedBy'])->find($id);
    }

    public function create(array $data){
        return TicketManagement::create($data);
    }

    public function update(TicketManagement $ticket,array $data){
        $ticket->update($data);
        return $ticket->fresh();
    }

    public function delete(TicketManagement $ticket){
        return $ticket->delete();
    }

    public function getLastTicket()
    {
        return TicketManagement::latest('id')->first();
    }
}