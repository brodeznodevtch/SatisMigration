<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionKitSellLine extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_id', 'variation_id', 'quantity'];
}
