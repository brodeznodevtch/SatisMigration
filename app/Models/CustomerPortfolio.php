<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerPortfolio extends Model
{
    protected $fillable = ['code', 'name', 'description', 'seller_id', 'business_id', 'status'];
}
