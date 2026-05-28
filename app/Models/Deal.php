<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SearchableAndFilterable;

class Deal extends Model
{
    use SearchableAndFilterable;
    protected $fillable = [
            'sponsor_id',
            'deal_title',
            'deal_description',
            // 'deal_type',
            'status', 
            'deal_type_id',
    ];

    public function sponsor(){
        return $this->belongsTo(Sponsor::class);
    }

    public function dealType(){
        return $this->belongsTo(DealType::class);
    } 

    public function invoices(){
        return $this->hasMany(Invoice::class,'deal_id');
    }
}
