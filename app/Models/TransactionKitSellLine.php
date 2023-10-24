<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionKitSellLine extends Model
{
    protected $fillable = ['transaction_id', 'variation_id', 'quantity'];
}
