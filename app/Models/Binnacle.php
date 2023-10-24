<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Binnacle extends Model
{
    protected $fillable = [
        'user_id',
        'reference',
        'module',
        'action',
        'old_record',
        'new_record',
        'realized_in',
        'machine_name',
        'ip',
        'city',
        'country',
        'latitude',
        'longitude',
        'domain',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
