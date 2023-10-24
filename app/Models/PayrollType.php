<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollType extends Model
{
    protected $fillable = [
        'name',
        'business_id',
    ];

    public function payrolls()
    {
        return $this->hasMany(\App\Models\Payroll::class);
    }
}
