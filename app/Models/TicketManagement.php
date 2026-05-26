<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketManagement extends Model
{
    protected $fillable = [
        'deal_id','sponsor_id','ticket_id','ticket_name','number_of_tickets','assigned_to','assigned_by','ticket_type',
        'status','distribution_date','location','description','ticket_attachment',
    ];

    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}