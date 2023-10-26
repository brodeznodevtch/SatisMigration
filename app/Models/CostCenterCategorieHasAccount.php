<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostCenterCategorieHasAccount extends Model
{
    use HasFactory;

    protected $fillable = ['categorie_id', 'account_id'];
}
