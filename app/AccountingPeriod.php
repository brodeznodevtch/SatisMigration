<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountingPeriod extends Model
{
    protected $fillable = ['name', 'month', 'fiscal_year_id', 'status', 'business_id'];

    public function year()
    {
        return $this->belongsTo(\App\FiscalYear::class);
    }

    public function entrie()
    {
        return $this->hasMany(\App\AccountingEntrie::class);
    }
}
