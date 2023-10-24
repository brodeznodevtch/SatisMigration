<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FiscalYear extends Model
{
    protected $fillable = ['business_id', 'year'];

    public function period()
    {
        return $this->hasMany(\App\Models\AccountingPeriod::class);
    }
}
