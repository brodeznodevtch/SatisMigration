<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RrhhSetting extends Model
{
    protected $table = 'rrhh_settings';

    protected $fillable = [
        'automatic_closing',
        'exit_time',
        'exempt_bonus',
        'vacation_percentage',
        'business_id',
    ];

    public function business()
    {
        return $this->belongsTo(\App\Models\Business::class);
    }
}
