<?php

namespace App\Optics;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FlowReason extends Model
{
    use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'business_id',
        'reason',
        'description',
        'created_by',
        'updated_by',
    ];

    /**
     * Return list of reasons for a business.
     *
     * @param  int  $business_id
     * @param  bool  $prepend_none
     * @param  array  $prepend_all
     * @return array
     */
    public static function forDropdown(int $business_id, bool $prepend_none = false, array $prepend_all = false): array
    {
        $query = FlowReason::where('business_id', $business_id);

        $all_reasons = $query->select('id', 'reason');
        $all_reasons = $all_reasons->pluck('reason', 'id');

        // Prepend none
        if ($prepend_none) {
            $all_reasons = $all_reasons->prepend(__('lang_v1.none'), '');
        }

        // Prepend all
        if ($prepend_all) {
            $all_reasons = $all_reasons->prepend(__('report.all'), '');
        }

        return $all_reasons;
    }
}
