<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RrhhPositionHistory extends Model
{
    protected $fillable = [
        'previous_department_id',
        'previous_position1_id',
        'new_department_id',
        'new_position1_id',
        'employee_id',
        'current',
        'rrhh_personnel_action_id',
    ];

    public function previousDepartment()
    {
        return $this->belongsTo(\App\RrhhData::class);
    }

    public function previousPosition1()
    {
        return $this->belongsTo(\App\RrhhData::class);
    }

    public function newDepartment()
    {
        return $this->belongsTo(\App\RrhhData::class);
    }

    public function newPosition1()
    {
        return $this->belongsTo(\App\RrhhData::class);
    }

    public function employee()
    {
        return $this->belongsTo(\App\Employees::class);
    }

    public function rrhhPersonnelAction()
    {
        return $this->belongsTo(\App\RrhhPersonnelAction::class);
    }
}
