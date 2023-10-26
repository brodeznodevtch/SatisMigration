<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimType extends Model
{
    use HasFactory;

    protected $fillable = ['correlative', 'name', 'description', 'resolution_time', 'required_customer', 'required_product', 'required_invoice', 'all_access'];

    public function claim()
    {
        return $this->hasMany(\App\Models\Claim::class);
    }
}
