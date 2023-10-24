<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeEntrie extends Model
{
    protected $fillable = ['name', 'description', 'short_name'];

    public function entrie()
    {
        return $this->hasMany(\App\Models\AccountingEntrie::class);
    }
}
