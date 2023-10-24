<?php

namespace App\Models;

use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use SoftDeletes, CascadeSoftDeletes;


    protected $cascadeDeletes = ['permission'];

    protected $fillable = ['name', 'description'];

    public function permission()
    {
        return $this->hasMany(\App\Models\Permission::class);
    }
}
