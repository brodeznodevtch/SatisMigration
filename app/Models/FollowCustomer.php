<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowCustomer extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'contact_type', 'contact_reason_id', 'product_cat_id', 'product_not_found', 'product_not_stock', 'products_not_found_desc', 'notes', 'contact_mode_id', 'date', 'register_by'];
}
