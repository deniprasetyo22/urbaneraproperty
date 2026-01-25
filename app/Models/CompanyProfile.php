<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyProfile extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'achievements' => 'array',
        'portfolio' => 'array',
    ];
}