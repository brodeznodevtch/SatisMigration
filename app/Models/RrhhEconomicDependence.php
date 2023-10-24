<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RrhhEconomicDependence extends Model
{
    protected $fillable = [
        'name',
        'birthdate',
        'phone',
        'type_relationship_id',
        'employee_id',
        'status',
    ];
}
