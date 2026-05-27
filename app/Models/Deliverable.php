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
        'attachment',
        'task_id',
        'sponsor_id',
        'assigned_to',
        'status',
        'status_updated_at',
        'distribution_date',
        'priority',
        'start_date',
        'due_date',
    ];

    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

    public function deliverType()
    {
        return $this->belongsTo(DeliverType::class);
    }

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class, 'sponsor_id');
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function attachments()
    {
        return $this->hasMany(DeliverableAttachment::class);
    }

    protected $casts = [
        'status_updated_at' => 'datetime',
        'distribution_date' => 'date',
        'start_date'        => 'date',
        'due_date'          => 'date',
    ];
}
