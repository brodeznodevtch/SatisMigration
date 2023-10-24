<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountingEntriesDetail extends Model
{
    protected $fillable = ['entrie_id', 'account_id', 'debit', 'credit', 'description'];

    public function account()
    {
        return $this->belongsTo(\App\Models\Catalogue::class);
    }

    public function entrie()
    {
        return $this->belongsTo('App\AccountingEnrie');
    }
}
