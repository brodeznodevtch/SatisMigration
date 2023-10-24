<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CostCenterCategorieHasAccount extends Model
{
    protected $fillable = ['categorie_id', 'account_id'];
}
