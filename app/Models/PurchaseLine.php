<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseLine extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function transaction()
    {
        return $this->belongsTo(\App\Models\Transaction::class);
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id');
    }

    public function variations()
    {
        return $this->belongsTo(\App\Models\Variation::class, 'variation_id');
    }

    public function tax_groups()
    {
        return $this->belongsTo(\App\Models\TaxGroup::class, 'tax_id');
    }

    /**
     * Set the quantity.
     *
     * @return float $value
     */
    public function getQuantityAttribute(string $value): float
    {
        return (float) $value;
    }
}
