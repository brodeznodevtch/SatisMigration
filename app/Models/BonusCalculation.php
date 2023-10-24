<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BonusCalculation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'from',
        'until',
        'days',
        'proportional',
        'status',
        'business_id',
        'deleted_at',
    ];

    public function business()
    {
        return $this->belongsTo(\App\Models\Business::class);
    }
}
