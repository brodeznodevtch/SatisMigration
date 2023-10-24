<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankTransaction extends Model
{
    protected $fillable = ['business_id', 'bank_account_id', 'accounting_entrie_id', 'type_bank_transaction_id', 'bank_checkbook_id', 'reference', 'date', 'amount', 'description', 'headline'];

    public function bankAccount()
    {
        return $this->belongsTo(\App\BankAccount::class);
    }

    public function entrie()
    {
        return $this->belongsTo(\App\AccountingEntrie::class, 'accounting_entrie_id');
    }
}
