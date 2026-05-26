<?php

namespace App\Services\Ticket;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ApiResponse;
use App\Constants\ApiMessages;
use App\Constants\StatusCodes;
use App\Repositories\Contracts\TicketRepositoryInterface;

class TicketService
{
    protected TicketRepositoryInterface $ticketRepo;

    public function __construct(TicketRepositoryInterface $ticketRepo)
    {
        $this->ticketRepo = $ticketRepo;
    }

    public function getAll($perPage = 10)
    {
        try {
            $tickets = $this->ticketRepo->paginate($perPage);
            return ApiResponse::success(
                $tickets,
                ApiMessages::TICKETS_FETCHED
            );
        } catch (Exception $e) {
            return ApiResponse::error(
                ApiMessages::ERROR,
                StatusCodes::SERVER_ERROR,
                $e->getMessage()
            );
        }
    }

    public function getById(int $id)
    {
        try {
            $ticket = $this->ticketRepo->find($id);
            if (!$ticket) {
                return ApiResponse::error(
                    ApiMessages::TICKET_NOT_FOUND,
                    StatusCodes::NOT_FOUND
                );
            }
            return ApiResponse::success(
                $ticket,
                ApiMessages::TICKET_FETCHED
            );
        } catch (Exception $e) {

            return ApiResponse::error(
                ApiMessages::ERROR,
                StatusCodes::SERVER_ERROR,
                $e->getMessage()
            );
        }
    }

    // public function create(array $data)
    // {
    //     try {

    //         $data['ticket_id'] =
    //             'TK' . strtoupper(Str::random(6));

    //         if (isset($data['assigned_to'])) {

    //             $data['assigned_by'] = Auth::id();

    //             $data['status'] = 'Assigned';
    //         }

    //         if (isset($data['ticket_attachment'])) {

    //             $data['ticket_attachment'] =
    //                 $data['ticket_attachment']
    //                 ->store('tickets', 'public');
    //         }

    //         $ticket = $this->ticketRepo->create($data);

    //         return ApiResponse::success(
    //             $ticket,
    //             ApiMessages::TICKET_CREATED,
    //             StatusCodes::CREATED
    //         );

    //     } catch (Exception $e) {

    //         return ApiResponse::error(
    //             ApiMessages::ERROR,
    //             StatusCodes::SERVER_ERROR,
    //             $e->getMessage()
    //         );
    //     }
    // }

    public function create(array $data)
    {
        try {
            $lastTicket = $this->ticketRepo->getLastTicket();
            if ($lastTicket && $lastTicket->ticket_id) {
                $lastNumber = (int) str_replace('TK', '', $lastTicket->ticket_id);

                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }

            $data['ticket_id'] =
                'TK' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

            if (isset($data['assigned_to'])) {
                $data['assigned_by'] = Auth::id();
                $data['status'] = 'Assigned';
            }

            if (isset($data['ticket_attachment'])) {
                $data['ticket_attachment'] =
                    $data['ticket_attachment']
                    ->store('tickets', 'public');
            }

            $ticket = $this->ticketRepo->create($data);
            return ApiResponse::success(
                $ticket,
                ApiMessages::TICKET_CREATED,
                StatusCodes::CREATED
            );
        } catch (Exception $e) {
            return ApiResponse::error(
                ApiMessages::ERROR,
                StatusCodes::SERVER_ERROR,
                $e->getMessage()
            );
        }
    }

    public function update(int $id, array $data)
    {
        try {
            $ticket = $this->ticketRepo->find($id);
            if (!$ticket) {
                return ApiResponse::error(
                    ApiMessages::TICKET_NOT_FOUND,
                    StatusCodes::NOT_FOUND
                );
            }

            if (isset($data['assigned_to'])) {
                $data['assigned_by'] = Auth::id();
                $data['status'] = 'Assigned';
            }
            if (isset($data['ticket_attachment'])) {
                if (
                    $ticket->ticket_attachment &&
                    Storage::disk('public')
                    ->exists($ticket->ticket_attachment)
                ) {
                    Storage::disk('public')
                        ->delete($ticket->ticket_attachment);
                }
                $data['ticket_attachment'] =
                    $data['ticket_attachment']
                    ->store('tickets', 'public');
            }

            $updatedTicket = $this->ticketRepo
                ->update($ticket, $data);
            return ApiResponse::success(
                $updatedTicket,
                ApiMessages::TICKET_UPDATED
            );
        } catch (Exception $e) {
            return ApiResponse::error(
                ApiMessages::ERROR,
                StatusCodes::SERVER_ERROR,
                $e->getMessage()
            );
        }
    }

    public function delete(int $id)
    {
        try {
            $ticket = $this->ticketRepo->find($id);
            if (!$ticket) {
                return ApiResponse::error(
                    ApiMessages::TICKET_NOT_FOUND,
                    StatusCodes::NOT_FOUND
                );
            }

            if (
                $ticket->ticket_attachment &&
                Storage::disk('public')
                ->exists($ticket->ticket_attachment)
            ) {
                Storage::disk('public')
                    ->delete($ticket->ticket_attachment);
            }

            $this->ticketRepo->delete($ticket);
            return ApiResponse::success(
                null,
                ApiMessages::TICKET_DELETED
            );
        } catch (Exception $e) {
            return ApiResponse::error(
                ApiMessages::ERROR,
                StatusCodes::SERVER_ERROR,
                $e->getMessage()
            );
        }
    }
}
