<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingPeriod extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'month', 'fiscal_year_id', 'status', 'business_id'];

    public function year()
    {
        return $this->belongsTo(\App\Models\FiscalYear::class);
    }

    public function entrie()
    {
        return $this->hasMany(\App\Models\AccountingEntrie::class);
    }
}
