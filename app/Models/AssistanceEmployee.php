<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssistanceEmployee extends Model
{
    protected $table = 'assistance_employees';

    protected $fillable = [
        'photo',
        'ip',
        'country',
        'city',
        'latitude',
        'longitude',
        'date',
        'time',
        'type',
        'status',
        'employee_id',
        'business_id',
    ];

    public function employee()
    {
        return $this->belongsTo(\App\Models\Employees::class);
    }

    public function business()
    {
        return $this->belongsTo(\App\Models\Business::class);
    }
}
