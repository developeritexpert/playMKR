<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\StoreInvoiceRequest;
use App\Http\Requests\Invoice\UpdateInvoiceRequest;
use App\Services\Invoice\InvoiceService;

class InvoiceController extends Controller
{
    protected $invoiceService;

    public function __construct(
        InvoiceService $invoiceService
    ) {
        $this->invoiceService = $invoiceService;
    }

    public function index()
    {
        return $this->invoiceService->index();
    }

    public function store(StoreInvoiceRequest $request)
    {
        return $this->invoiceService->store(
            $request->validated()
        );
    }

    public function show($id)
    {
        return $this->invoiceService->show($id);
    }

    public function update(
        UpdateInvoiceRequest $request,
        $id
    ) {
        return $this->invoiceService->update(
            $id,
            $request->validated()
        );
    }

    public function destroy($id)
    {
        return $this->invoiceService->destroy($id);
    }
}