<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitGroupLines extends Model
{
    use SoftDeletes;


    protected $fillable = ['unit_id', 'unit_group_id', 'factor', 'default'];

    /**
     * Get unit group info
     */
    public function unitGroup()
    {
        return $this->belongsTo(\App\Models\UnitGroup::class);
    }

    public function unit()
    {
        return $this->belongsTo(\App\Models\Unit::class);
    }
}
