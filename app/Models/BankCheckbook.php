<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankCheckbook extends Model
{
    use HasFactory;

    protected $table = 'bank_checkbooks';

    protected $fillable = [
        'business_id',
        'name',
        'description',
        'serie',
        'initial_correlative',
        'final_correlative',
        'actual_correlative',
        'bank_account_id',
        'status',
    ];

    public function account()
    {
        return $this->belongsTo(\App\Models\BankAccount::class);
    }
}
