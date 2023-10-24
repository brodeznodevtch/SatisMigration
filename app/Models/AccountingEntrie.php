<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountingEntrie extends Model
{
    protected $fillable = ['date', 'number', 'correlative', 'short_name', 'description', 'accounting_period_id', 'type_entrie_id', 'business_location_id', 'status', 'business_id'];

    public function detail()
    {
        return $this->hasMany(\App\Models\AccountingEntriesDetail::class);
    }

    public function bankTransaction()
    {
        return $this->hasOne(\App\Models\BankTransaction::class);
    }

    public function type()
    {
        return $this->belongsTo(\App\Models\TypeEntrie::class, 'type_entrie_id');
    }

    public function period()
    {
        return $this->belongsTo(\App\Models\AccountingPeriod::class);
    }
}
