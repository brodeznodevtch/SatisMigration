<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'business_id', 'state_id', 'status'];

    public function state()
    {
        return $this->belongsTo(\App\Models\State::class);
    }
}
