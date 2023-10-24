<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CostCenterCategorie extends Model
{
    protected $fillable = ['cost_center_id', 'name', 'description'];

    public function center()
    {
        return $this->belongsTo(\App\Models\CostCenter::class);
    }
}
