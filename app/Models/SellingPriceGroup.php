<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SellingPriceGroup extends Model
{
    use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Return list of selling price groups
     *
     * @param  int  $business_id
     * @return array
     */
    public static function forDropdown(int $business_id): array
    {
        $price_groups = SellingPriceGroup::where('business_id', $business_id)
            ->get();

        $dropdown = [];

        if (auth()->user()->can('access_default_selling_price')) {
            $dropdown[0] = __('lang_v1.default_selling_price');
        }

        foreach ($price_groups as $price_group) {
            if (auth()->user()->can('selling_price_group.'.$price_group->id)) {
                $dropdown[$price_group->id] = $price_group->name;
            }
        }

        return $dropdown;
    }

    /**
     * Counts total number of selling price groups
     *
     * @param  int  $business_id
     * @return array
     */
    public static function countSellingPriceGroups(int $business_id): array
    {

        $count = SellingPriceGroup::where('business_id', $business_id)
            ->count();

        return $count;
    }
}
