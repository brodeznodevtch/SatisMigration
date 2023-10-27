<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $cascadeDeletes = ['permission'];

    protected $fillable = ['name', 'description'];

    public function permission()
    {
        return $this->hasMany(\App\Models\Permission::class);
    }
}
