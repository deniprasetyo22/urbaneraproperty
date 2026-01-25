<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function residence()
    {
        return $this->belongsTo(Residence::class);
    }

    protected $casts = [
        'description'        => 'array',
        'nearby_amenities'   => 'array',
        'property_details'   => 'array',
        'property_features'  => 'array',
        'floor_plan'         => 'array',
        'media'             => 'array',
    ];

    protected static function booted()
    {
        static::creating(function ($property) {
            $property->slug = Str::slug($property->name);
        });

        static::updating(function ($property) {
            // hanya update slug jika name berubah
            if ($property->isDirty('name')) {
                $property->slug = Str::slug($property->name);
            }
        });
    }


}