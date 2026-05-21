<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DealType extends Model
{
    protected $fillable = ['slug', 'name'];

    public function deals()
    {
        return $this->hasMany(Deal::class);
    }
}