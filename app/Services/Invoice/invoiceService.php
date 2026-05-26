<?php

namespace App\Services\Invoice;

use App\Constants\ApiMessages;
use App\Constants\StatusCodes;
use App\Helpers\ApiResponse;
use App\Repositories\Invoice\InvoiceRepositoryInterface;

class InvoiceService
{
    protected $invoiceRepo;

    public function __construct(InvoiceRepositoryInterface $invoiceRepo) {
        $this->invoiceRepo = $invoiceRepo;
    }

    public function index()
    {
        $invoices = $this->invoiceRepo->getAll();

        return ApiResponse::success(
            $invoices,
            ApiMessages::INVOICE_LIST,
            StatusCodes::OK
        );
    }

    public function show($id)
    {
        $invoice = $this->invoiceRepo->findById($id);

        if (!$invoice) {
            return ApiResponse::error(
                ApiMessages::INVOICE_NOT_FOUND,
                StatusCodes::NOT_FOUND
            );
        }

        return ApiResponse::success(
            $invoice,
            ApiMessages::INVOICE_FETCHED,
            StatusCodes::OK
        );
    }

    public function store(array $data)
    {
        $invoice = $this->invoiceRepo->create($data);

        return ApiResponse::success(
            $invoice,
            ApiMessages::INVOICE_CREATED,
            StatusCodes::CREATED
        );
    }

    public function update($id, array $data)
    {
        $invoice = $this->invoiceRepo->update($id, $data);

        if (!$invoice) {
            return ApiResponse::error(
                ApiMessages::INVOICE_NOT_FOUND,
                StatusCodes::NOT_FOUND
            );
        }

        return ApiResponse::success(
            $invoice,
            ApiMessages::INVOICE_UPDATED,
            StatusCodes::OK
        );
    }

    public function destroy($id)
    {
        $deleted = $this->invoiceRepo->delete($id);

        if (!$deleted) {
            return ApiResponse::error(
                ApiMessages::INVOICE_NOT_FOUND,
                StatusCodes::NOT_FOUND
            );
        }

        return ApiResponse::success(
            [],
            ApiMessages::INVOICE_DELETED,
            StatusCodes::OK
        );
    }
}