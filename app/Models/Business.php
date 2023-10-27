<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'business';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'woocommerce_api_settings'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['woocommerce_api_settings'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'ref_no_prefixes' => 'array',
        'enabled_modules' => 'array',
        'email_settings' => 'array',
        'sms_settings' => 'array',
    ];

    /**
     * Get the unit group list
     */
    public function unitGroup()
    {
        return $this->hasMany('App\UnitGroups');
    }

    /**
     * Get the owner details
     */
    public function owner()
    {
        return $this->hasOne(\App\Models\User::class, 'id', 'owner_id');
    }

    /**
     * Get the Business currency.
     */
    public function currency()
    {
        return $this->belongsTo(\App\Models\Currency::class);
    }

    /**
     * Get the Business currency.
     */
    public function locations()
    {
        return $this->hasMany(\App\Models\BusinessLocation::class);
    }

    /**
     * Get the Business printers.
     */
    public function printers()
    {
        return $this->hasMany(\App\Models\Printer::class);
    }

    /**
     * Get the Business subscriptions.
     */
    public function subscriptions()
    {
        return $this->hasMany('\Modules\Superadmin\Entities\Subscription');
    }

    /**
     * Get the state.
     */
    public function state()
    {
        return $this->belongsTo(\App\Models\State::class);
    }

    /**
     * Get the setting.
     */
    public function setting()
    {
        return $this->hasOne(\App\Setting::class);
    }

    /**
     * Creates a new business based on the input provided.
     *
     * @return object
     */
    public static function create_business($details): object
    {
        $business = Business::create($details);

        return $business;
    }

    /**
     * Updates a business based on the input provided.
     *
     * @param  int  $business_id
     * @param  array  $details
     * @return object
     */
    public static function update_business(int $business_id, array $details): object
    {
        if (! empty($details)) {
            Business::where('id', $business_id)
                ->update($details);
        }
    }
}
