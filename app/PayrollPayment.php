<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayrollPayment extends Model
{
    protected $fillable = [
        'check_number', 
        'reference', 
        'payment_id',
        'bank_account_id', 
        'bank_checkbook_id', 
        'payroll_id'
    ];
    
    public function payroll(){
        return $this->belongsTo('App\Payroll');
    }

    public function payment() {
        return $this->belongsTo('App\RrhhData');
    }

    public function bankAccount() {
        return $this->belongsTo('App\BankAccount');
    }
}
