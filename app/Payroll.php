<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payroll extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'payroll_type_id',
        'name',
        'year',
        'month',
        'days',
        'start_date',
        'end_date',
        'payroll_status_id',
        'isr_id',
        'payment_period_id',
        'business_id',
        'deleted_at',
    ];

    public function payrollType()
    {
        return $this->belongsTo(\App\PayrollType::class);
    }

    public function payrollStatus()
    {
        return $this->belongsTo(\App\PayrollStatus::class);
    }

    public function paymentPeriod()
    {
        return $this->belongsTo(\App\PaymentPeriod::class);
    }

    public function calculationType()
    {
        return $this->belongsTo('App\Calculation');
    }

    public function payrollDetails()
    {
        return $this->hasMany(\App\PayrollDetail::class);
    }

    public function business()
    {
        return $this->belongsTo(\App\Business::class);
    }
}
