<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClaimType extends Model
{
    protected $fillable = ['correlative', 'name', 'description', 'resolution_time', 'required_customer', 'required_product', 'required_invoice', 'all_access'];

    public function claim()
    {
        return $this->hasMany(\App\Models\Claim::class);
    }
}
