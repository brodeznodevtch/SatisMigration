<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use DB;
use Illuminate\Database\Eloquent\Model;

class Catalogue extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'parent', 'type', 'status', 'level', 'catalogue_id', 'business_id'];

    public function detail()
    {
        return $this->hasMany(\App\Models\AccountingEntriesDetail::class);
    }

    public function child()
    {
        return $this->hasMany(\App\Models\Catalogue::class, 'parent')->select(['id', DB::raw("CONCAT(code, ' ', name) AS text"), 'parent']);
    }

    public function children()
    {
        return $this->child()->with('children');
    }

    public function parent()
    {
        return $this->belongsTo(\App\Models\Catalogue::class, 'parent')->select(['id', 'name', DB::raw("CONCAT(code, ' ', name) AS text"), 'parent']);
    }

    public function padre()
    {
        return $this->parent();
    }

    public function parent_rec()
    {
        return $this->parent()->with('parent_rec');
    }

    public function latestMeasure()
    {
        return $this->hasOne(Catalogue::class)->latest();
    }

    public function bankTransaction()
    {
        return $this->hasMany(\App\Models\BankTransaction::class);
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }
}
