<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RrhhClassAction extends Model
{
    protected $fillable = [
        'rrhh_class_personnel_action_id',
        'rrhh_required_action_id',
    ];

    public function rrhhClassPersonnelAction()
    {
        return $this->belongsTo(\App\Models\RrhhClassPersonnelAction::class);
    }

    public function rrhhRequiredAction()
    {
        return $this->belongsTo(\App\Models\RrhhRequiredAction::class);
    }
}
