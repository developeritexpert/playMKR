<?php

namespace App\Http\Controllers\Ticket;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Ticket\TicketService;
use App\Http\Requests\Ticket\StoreTicketRequest;
use App\Http\Requests\Ticket\UpdateTicketRequest;

class TicketController extends Controller
{
    protected TicketService $ticketService;

    public function __construct(
        TicketService $ticketService
    ) {
        $this->ticketService = $ticketService;
    }

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        return $this->ticketService
            ->getAll($perPage);
    }

    public function store(StoreTicketRequest $request)
    {
        return $this->ticketService
            ->create($request->validated());
    }

    public function show($id)
    {
        return $this->ticketService
            ->getById($id);
    }

    public function update(
        UpdateTicketRequest $request,
        $id
    ) {
        return $this->ticketService
            ->update($id, $request->validated());
    }

    public function destroy($id)
    {
        return $this->ticketService
            ->delete($id);
    }
}
