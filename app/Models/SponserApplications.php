<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SponserApplications extends Model
{
        protected $table = 'sponser_applications';

        protected $fillable = [
            'name',
            'email',
            'contact_number',
            'company_name',
            'website_url',
            'status',
            'approved_at',
            'industry',
            'address',
        ];

        protected $casts = [
            'approved_at' => 'datetime',
        ];
}
