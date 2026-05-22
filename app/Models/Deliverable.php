<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deliverable extends Model
{
    protected $fillable = [
        'deal_id',
        'deliver_type_id',
        'title',
        'description',
        'quantity',
        'attachment'
    ];

    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

    public function deliverType()
    {
        return $this->belongsTo(DeliverType::class);
    }
}
