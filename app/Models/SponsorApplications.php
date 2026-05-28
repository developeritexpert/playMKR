<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SearchableAndFilterable;  

class SponsorApplications extends Model
{
        use SearchableAndFilterable;
        protected $table = 'sponsor_applications';

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
