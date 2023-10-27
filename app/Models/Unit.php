<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Return list of units for a business
     *
     * @param  int  $business_id
     * @param  bool  $show_none = true
     * @return array
     */
    public static function forDropdown(int $business_id): array
    {

        $query = Unit::where('business_id', $business_id);
        $all_emp = $query->select('id', 'actual_name');
        $all_emp = $all_emp->pluck('actual_name', 'id');

        return $all_emp;
    }

    /**
     * Get the detail lines
     */
    public function unitGroupLines()
    {
        return $this->hasMany(\App\Models\UnitGroupLines::class);
    }

    public function product()
    {
        return $this->hasMany(\App\Models\Product::class);
    }
}
