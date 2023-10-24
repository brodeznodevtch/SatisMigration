<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RrhhSalarialConstance extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'template',
        'margin_top',
        'margin_bottom',
        'margin_left',
        'margin_right',
        'status',
        'business_id',
        'deleted_at',
    ];
}