<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SearchableAndFilterable;

class Invoice extends Model
{
    use SearchableAndFilterable;
    protected $fillable = [
        'deal_id',
        'sponsor_id',
        'invoice_id',
        'invoice_title',
        'invoice_amount',
        'tax',
        'discount',
        'total_amount',
        'currency',
        'invoice_date',
        'due_date',
        'payment_status',
        'billing_address',
        'contact_email',
    ];

    public function deal(){
        return $this->belongsTo(Deal::class, 'deal_id');
    }

    public function sponsor(){
        return $this->belongsTo(Sponsor::class,'sponsor_id');
    }
}
