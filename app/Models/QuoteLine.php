<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteLine extends Model
{
    protected $guarded = ['id'];

    public function quote()
    {
        return $this->belongsTo(\App\Models\Quote::class);
    }

    public function variation()
    {
        return $this->belongsTo(\App\Models\Variation::class, 'variation_id');
    }
}
