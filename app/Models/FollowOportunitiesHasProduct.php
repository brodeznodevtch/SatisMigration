<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowOportunitiesHasProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'follow_oportunitie_id',
        'variation_id',
        'quantity',
        'required_quantity',
    ];
}
