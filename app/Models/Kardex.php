<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kardex extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function movement_type()
    {
        return $this->belongsTo(\App\Models\MovementType::class, 'movement_type_id');
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id');
    }
}
