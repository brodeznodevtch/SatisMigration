<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusClaim extends Model
{
    protected $fillable = ['correlative', 'name', 'status', 'predecessor', 'color'];
}
