<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deliverable extends Model
{
    protected $fillable = [
        'deal_id',
        'title',
        'description',
        'type',
        'quantity',
        'upload_attachment',
    ];

    public function deal(){
        return $this->belongTo(Deal::class);
    }
}
