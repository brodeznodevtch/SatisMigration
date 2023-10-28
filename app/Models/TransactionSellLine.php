<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionSellLine extends Model
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

    public function modifiers()
    {
        return $this->hasMany(\App\Models\TransactionSellLine::class, 'parent_sell_line_id');
    }

    /**
     * Get the quantity column.
     *
     * @return float $value
     */
    public function getQuantityAttribute(string $value): float
    {
        return (float) $value;
    }

    public function lot_details()
    {
        return $this->belongsTo(\App\Models\PurchaseLine::class, 'lot_no_line_id');
    }

    public function get_discount_amount()
    {
        $discount_amount = 0;
        if (! empty($this->line_discount_type) && ! empty($this->line_discount_amount)) {
            if ($this->line_discount_type == 'fixed') {
                $discount_amount = $this->line_discount_amount;
            } elseif ($this->line_discount_type == 'percentage') {
                $discount_amount = ($this->unit_price * $this->line_discount_amount) / 100;
            }
        }

        return $discount_amount;
    }
}
