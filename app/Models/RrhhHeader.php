<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RrhhHeader extends Model
{
    protected $fillable = ['name', 'description', 'status'];

    public function data()
    {

        return $this->hasMany(\App\Models\RrhhData::class);
    }
}
