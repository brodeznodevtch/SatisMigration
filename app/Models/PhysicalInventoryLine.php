<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PhysicalInventoryLine extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'physical_inventory_id',
        'product_id',
        'variation_id',
        'quantity',
        'stock',
        'difference',
        'price',
        'created_by',
        'updated_by',
    ];

    /**
     * Get product.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id');
    }

    /**
     * Get variation.
     */
    public function variation(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Variation::class, 'variation_id');
    }
}
