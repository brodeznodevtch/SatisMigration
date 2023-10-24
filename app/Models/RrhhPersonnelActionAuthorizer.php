<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RrhhPersonnelActionAuthorizer extends Model
{
    protected $fillable = ['rrhh_personnel_action_id', 'user_id', 'authorized'];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function personnelAction()
    {
        return $this->belongsTo(\App\Models\RrhhPersonnelAction::class);
    }
}
