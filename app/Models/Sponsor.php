<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    protected $fillable = [
        'name',
        'company_name',
        'sponser_name',
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

}
