<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimTypeHasUser extends Model
{
    use HasFactory;

    protected $fillable = ['claim_id', 'user_id'];
}
