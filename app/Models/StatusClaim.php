<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusClaim extends Model
{
    use HasFactory;

    protected $fillable = ['correlative', 'name', 'status', 'predecessor', 'color'];
}
