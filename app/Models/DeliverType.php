<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DeliverType extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    // Convent name into slug
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($deliverType) {
            if (empty($deliverType->slug)) {
                $deliverType->slug = Str::slug($deliverType->name);
            }
        });
        static::updating(function ($deliverType) {

            if ($deliverType->isDirty('name')) {
                $deliverType->slug = Str::slug($deliverType->name);
            }
        });
}

    public function deliverables(){
        return $this->hasMany(Deliverable::class, 'deliver_type_id');
    }
}
