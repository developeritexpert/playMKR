<?php
namespace App\Repositories\Invoice;

use App\Models\Invoice;
use Illuminate\Support\Str;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    // public function getAll(){
    //     return Invoice::latest()->get();
    // }
    public function paginate(array $filters = [], int $perPage = 10)
    {
        // Search by Invoice ID, Invoice title, Deal title, or Sponsor name
        return Invoice::with(['deal', 'sponsor'])
            ->filterAndSearch($filters, ['invoice_id', 'invoice_title', 'deal.deal_title', 'sponsor.name'])
            ->paginate($perPage);
    }

    public function findById($id){
        return Invoice::find($id);
    }

    public function create(array $data){
    $lastInvoice = Invoice::latest()->first();
    if ($lastInvoice){
        $lastNumber = (int) str_replace('INV', '', $lastInvoice->invoice_id);
        $newNumber = $lastNumber + 1;
    } else {
        $newNumber = 1;
    }

    $data['invoice_id'] = 'INV' . str_pad($newNumber, 3,'0', STR_PAD_LEFT);
    return Invoice::create($data);
}

    public function update($id, array $data){
        $invoice = Invoice::find($id);
        if (!$invoice) {
            return null;
        }
        $invoice->update($data);
        return $invoice;
    }

    public function delete($id){
        $invoice = Invoice::find($id);
        if (!$invoice) {
            return false;
        }
        return $invoice->delete();
    }
}