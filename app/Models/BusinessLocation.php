<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessLocation extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the Business currency.
     */
    public function business()
    {
        return $this->belongsTo(\App\Models\Business::class);
    }

    /**
     * Return list of locations for a business
     *
     * @param  int  $business_id
     * @param  bool  $show_all = false
     * @param  array  $receipt_printer_type_attribute =
     * @return array
     */
    public static function forDropdown(int $business_id, bool $show_all = false, array $receipt_printer_type_attribute = false): array
    {
        $query = BusinessLocation::where('business_id', $business_id);

        $permitted_locations = auth()->user()->permitted_locations();
        if ($permitted_locations != 'all') {
            $query->whereIn('id', $permitted_locations);
        }

        $locations = $query->pluck('name', 'id');

        if ($show_all) {
            $locations->prepend(__('report.all_locations'), '');
        }

        if ($receipt_printer_type_attribute) {
            $attributes = collect($query->get())->mapWithKeys(function ($item) {
                return [$item->id => ['data-receipt_printer_type' => $item->receipt_printer_type]];
            })->all();

            return ['locations' => $locations, 'attributes' => $attributes];
        } else {
            return $locations;
        }
    }
}
