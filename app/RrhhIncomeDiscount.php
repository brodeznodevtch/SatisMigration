<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RrhhIncomeDiscount extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'total_value',
        'quota',
        'quota_value',
        'quotas_applied',
        'balance_to_date',
        'start_date',
        'end_date',
        'payment_period_id',
        'rrhh_type_income_discount_id',
        'employee_id',
    ];

    public function rrhhTypeIncomeDiscount()
    {
        return $this->belongsTo(\App\RrhhTypeIncomeDiscount::class);
    }

    public function paymentPeriod()
    {
        return $this->belongsTo(\App\PaymentPeriod::class);
    }

    public function employee()
    {
        return $this->belongsTo(\App\Employees::class);
    }
}
