<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerVehicle extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function brand()
    {
        return $this->belongsTo(\App\Models\Brands::class, 'brand_id');
    }
}
