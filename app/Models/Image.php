<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images_slide';

    protected $fillable = [
        'name',
        'description',
        'path',
        'is_active',
        'business_id',
    ];
}
