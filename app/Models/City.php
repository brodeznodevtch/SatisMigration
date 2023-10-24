<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name', 'business_id', 'state_id', 'status'];

    public function state()
    {
        return $this->belongsTo(\App\Models\State::class);
    }
}
