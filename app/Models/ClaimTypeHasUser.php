<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClaimTypeHasUser extends Model
{
    protected $fillable = ['claim_id', 'user_id'];
}
