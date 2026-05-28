<?php

namespace App\Http\Controllers\Admin\Invoice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\StoreInvoiceRequest;
use App\Http\Requests\Invoice\UpdateInvoiceRequest;
use App\Services\Admin\Invoice\InvoiceService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    protected $invoiceService;

    public function __construct(InvoiceService $invoiceService) {
        $this->invoiceService = $invoiceService;
    }

    public function index(Request $request)
    {
        $perPage = $request->query('limit', $request->query('per_page', 10));
        $filters = $request->only(['search', 'status']);
        
        return $this->invoiceService->index($filters, $perPage);
    }

    public function store(StoreInvoiceRequest $request){
        return $this->invoiceService->store($request->validated());
    }

    public function show($id){
        return $this->invoiceService->show($id);
    }

    public function update(UpdateInvoiceRequest $request,$id){
        return $this->invoiceService->update($id,$request->validated());
    }

    public function destroy($id){
        return $this->invoiceService->destroy($id);
    }
}