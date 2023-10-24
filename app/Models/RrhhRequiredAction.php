<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RrhhRequiredAction extends Model
{
    protected $fillable = [
        'name',
    ];

    public function rrhhClassActions()
    {
        return $this->hasMany(\App\Models\RrhhClassAction::class);
    }
}
