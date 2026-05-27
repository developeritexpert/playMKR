<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliverableAttachment extends Model
{
    protected $fillable = [
        'deliverable_id',
        'file_path',
    ];

    public function deliverable()
    {
        return $this->belongsTo(Deliverable::class);
    }
}