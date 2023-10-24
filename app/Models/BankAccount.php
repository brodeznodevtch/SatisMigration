<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankAccount extends Model
{
    use SoftDeletes;


    protected $fillable = ['business_id', 'bank_id', 'catalogue_id', 'name', 'description', 'type', 'number'];

    public function bankTransaction()
    {
        return $this->hasMany('App\bankTransaction');
    }

    public function bank()
    {
        return $this->belongsTo(\App\Models\Bank::class);
    }

    public function catalogue()
    {
        return $this->belongsTo(\App\Models\Catalogue::class);
    }

    public function checkbook()
    {
        return $this->hasMany(\App\Models\BankCheckbook::class);
    }
}
