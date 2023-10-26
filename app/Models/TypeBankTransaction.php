<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeBankTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'type_entrie_id', 'enable_checkbook', 'enable_headline', 'enable_date_constraint'];
}
