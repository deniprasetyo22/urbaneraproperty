<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Residence extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function brochure()
    {
        return $this->hasOne(Brochure::class);
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    protected static function booted()
    {
        static::creating(function ($residence) {
            $residence->slug = Str::slug($residence->name);
        });

        static::updating(function ($residence) {
            // hanya update slug jika name berubah
            if ($residence->isDirty('name')) {
                $residence->slug = Str::slug($residence->name);
            }
        });

        static::deleted(function ($residence) {

            if ($residence->isForceDeleting()) {
                // FORCE DELETE (PERMANEN)

                // 1. Hapus Properties satu per satu (agar event Property::deleted jalan & hapus testimonial)
                $residence->properties()->withTrashed()->get()->each(function ($property) {
                    $property->forceDelete();
                });

                // 2. Hapus Brochure (Jika brochure punya logic hapus file, gunakan each juga)
                $residence->brochure()->withTrashed()->get()->each(function ($brochure) {
                    $brochure->forceDelete();
                });

                // 3. Testimonial (agar event Testimonial::deleted jalan)
                $residence->testimonials()->withTrashed()->get()->each(function ($testimonial) {
                    $testimonial->forceDelete();
                });

            } else {
                // SOFT DELETE (TONG SAMPAH)

                // 1. Soft Delete Properties satu per satu
                $residence->properties->each(function ($property) {
                    $property->delete();
                    // Saat ini dijalankan, Property model akan otomatis menghapus Testimonial-nya
                });

                // 2. Soft Delete Brochure
                $residence->brochure->each(function ($brochure) {
                    $brochure->delete();
                });

                // 3. Soft Delete Testimonial
                $residence->testimonials->each(function ($testimonial) {
                    $testimonial->delete();
                });
            }
        });

        static::restored(function ($residence) {
            // RESTORE
            $residence->properties()->withTrashed()->get()->each(function ($property) {
                $property->restore();
            });

            $residence->brochure()->withTrashed()->get()->each(function ($brochure) {
                $brochure->restore();
            });

            $residence->testimonials()->withTrashed()->get()->each(function ($testimonial) {
                $testimonial->restore();
            });
        });

    }
}