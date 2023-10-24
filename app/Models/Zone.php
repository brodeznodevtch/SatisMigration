<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $fillable = ['name', 'business_id'];

    public function state()
    {
        return $this->hasMany(\App\Models\State::class);
    }
}
