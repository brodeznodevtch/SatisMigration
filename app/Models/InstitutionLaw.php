<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstitutionLaw extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'employeer_number', 'business_id', 'deleted_at'];

    public function business()
    {
        return $this->belongsTo(\App\Models\Business::class);
    }
}
