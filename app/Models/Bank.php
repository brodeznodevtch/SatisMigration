<?php

namespace App\Models;

use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
    use SoftDeletes, CascadeSoftDeletes;


    protected $cascadeDeletes = ['bankAccount'];

    protected $fillable = ['name', 'business_id', 'print_format'];

    public function bankAccount()
    {
        return $this->hasMany('App\bankAccount');
    }

    public function employees()
    {
        return $this->hasMany(\App\Models\Employees::class);
    }
}
