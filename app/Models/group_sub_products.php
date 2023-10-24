<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class group_sub_products extends Model
{
    //
    protected $guarded = ['id'];

    protected $table = 'group_sub_products';

    protected $fillable = ['productid', 'business_id', 'quantity', 'principal_product'];

    public $timestamps = false;
}
