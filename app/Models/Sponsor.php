<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SearchableAndFilterable;

class Sponsor extends Model
{
    use SearchableAndFilterable;
    protected $fillable = [
        'user_id',
        'name',
        'company_name',
        'sponsor_name',
        'industry',
        'website',
        'primary_contact',
        'email',
        'phone',
        'location',
    ];

    public function deal(){
        return $this->hasMany(deal::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function invoices(){
        return $this->hasMany(Invoice::class,'sponsor_id');
    }

}
