<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'username', 'email', 'password', 'business_id', 'cmmsn_percent', 'is_cmmsn_agnt', 'contact_no', 'address', 'language', 'status', 'deleted_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    /**
     * Get the business that owns the user.
     */
    public function business()
    {
        return $this->belongsTo(\App\Models\Business::class);
    }

    /**
     * The contact the user has access to.
     * Applied only when selected_contacts is true for a user in
     * users table
     */
    /*public function contactAccess()
    {
        return $this->belongsToMany(\App\Contact::class, 'user_contact_access');
    }*/

    /**
     * Creates a new user based on the input provided.
     *
     * @return object
     */
    public static function create_user($details)
    {
        $user = User::create([
            'first_name' => $details['first_name'],
            'last_name' => $details['last_name'],
            'username' => $details['username'],
            'email' => $details['email'],
            'password' => Hash::make($details['password']),
            'language' => ! empty($details['language']) ? $details['language'] : 'es',
        ]);

        return $user;
    }

    /**
     * Gives locations permitted for the logged in user
     *
     * @return string or array
     */
    public static function permitted_locations()
    {
        if (auth()->user()->can('access_all_locations')) {
            return 'all';
        } else {
            $business_id = request()->session()->get('user.business_id');
            $permitted_locations = [];
            $all_locations = BusinessLocation::where('business_id', $business_id)->get();
            foreach ($all_locations as $location) {
                if (auth()->user()->can('location.'.$location->id)) {
                    $permitted_locations[] = $location->id;
                }
            }

            return $permitted_locations;
        }
    }

    /**
     * Returns if a user can access the input location
     *
     * @param: int $location_id
     *
     * @return bool
     */
    public static function can_access_this_location($location_id)
    {
        $permitted_locations = User::permitted_locations();

        if ($permitted_locations == 'all' || in_array($location_id, $permitted_locations)) {
            return true;
        }

        return false;
    }

    /**
     * Return list of users dropdown for a business
     *
     * @param $business_id int
     * @param $prepend_none = true (boolean)
     * @param $include_commission_agents = false (boolean)
     * @return array users
     */
    public static function forDropdown($business_id, $prepend_none = true, $include_commission_agents = false, $prepend_all = false)
    {

        $query = User::where('business_id', $business_id);
        if (! $include_commission_agents) {
            $query->where('is_cmmsn_agnt', 0);
        }

        $all_users = $query->select('id', DB::raw("CONCAT(COALESCE(first_name,''),' ',COALESCE(last_name,'')) as full_name"));

        $users = $all_users->pluck('full_name', 'id');

        //Prepend none
        if ($prepend_none) {
            $users = $users->prepend(__('lang_v1.none'), '');
        }

        //Prepend all
        if ($prepend_all) {
            $users = $users->prepend(__('messages.all'), '');
        }

        return $users;
    }

    /**
     * Return list of users dropdown for all business
     *
     * @param $business_id int
     * @param $prepend_none = true (boolean)
     * @param $include_commission_agents = false (boolean)
     * @return array users
     */
    public static function forDropdownAllBusiness($prepend_none = false, $include_commission_agents = false, $prepend_all = false)
    {
        $query = User::all();

        if (! $include_commission_agents) {
            $query->where('is_cmmsn_agnt', 0);
        }

        $all_users = $query->select('id', DB::raw("CONCAT(COALESCE(first_name,''), ' ', COALESCE(last_name,'')) as full_name"));

        $users = $all_users->pluck('full_name', 'id');

        // Prepend none
        if ($prepend_none) {
            $users = $users->prepend(__('lang_v1.none'), '');
        }

        // Prepend all
        if ($prepend_all) {
            $users = $users->prepend(__('messages.all'), '');
        }

        return $users;
    }

    /**
     * Return list of sales commission agents dropdown for a business
     *
     * @param $business_id int
     * @param $prepend_none = true (boolean)
     * @return array users
     */
    public static function saleCommissionAgentsDropdown($business_id, $prepend_none = true)
    {

        $all_cmmsn_agnts = User::where('business_id', $business_id)
            ->where('is_cmmsn_agnt', 1)
            ->select('id', DB::raw("CONCAT(COALESCE(first_name,''),' ',COALESCE(last_name,'')) as full_name"));

        $users = $all_cmmsn_agnts->pluck('full_name', 'id');

        //Prepend none
        if ($prepend_none) {
            $users = $users->prepend(__('lang_v1.none'), '');
        }

        return $users;
    }

    /**
     * Return list of sales commission agents dropdown for all business
     *
     * @param $business_id int
     * @param $prepend_none = true (boolean)
     * @return array users
     */
    public static function saleCommissionAgentsDropdownAllBusiness($prepend_none = false)
    {
        $all_cmmsn_agnts = User::where('is_cmmsn_agnt', 1)
            ->select('id', DB::raw("CONCAT(COALESCE(first_name,''), ' ', COALESCE(last_name, '')) as full_name"));

        $users = $all_cmmsn_agnts->pluck('full_name', 'id');

        // Prepend none
        if ($prepend_none) {
            $users = $users->prepend(__('lang_v1.none'), '');
        }

        return $users;
    }

    /**
     * Return list of users dropdown for a business
     *
     * @param $business_id int
     * @param $prepend_none = true (boolean)
     * @return array users
     */
    public static function allUsersDropdown($business_id, $prepend_none = true)
    {

        $all_users = User::where('business_id', $business_id)
            ->select('id', DB::raw("CONCAT(COALESCE(first_name,''),' ',COALESCE(last_name,'')) as full_name"));

        $users = $all_users->pluck('full_name', 'id');

        //Prepend none
        if ($prepend_none) {
            $users = $users->prepend('None', '');
        }

        return $users;
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getUserFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function newNotification()
    {
        $this->notify(new Notification);
    }

    /**
     * Return true/false based on selected_contact access
     *
     * @return bool
     */
    public static function isSelectedContacts($user_id)
    {
        $user = User::findOrFail($user_id);

        return (bool) $user->selected_contacts;
    }

    public function permittedBusiness()
    {
        return User::where('username', $this->username)
            ->pluck('business_id')
            ->toArray();
    }

    public static function CustodiansDropdown($business_id, $prepend_none = true)
    {
        $all_custodians = User::where('business_id', $business_id)
            ->whereIn('id', function ($query) {
                $query->select('user_id')->from('special_permisions')->where('custodian', 1);
            })
            ->select('id', DB::raw("CONCAT(COALESCE(first_name,''),' ',COALESCE(last_name,'')) as full_name"));

        $custodians = $all_custodians->pluck('full_name', 'id');

        //Prepend none
        if ($prepend_none) {
            $custodians = $custodians->prepend(__('lang_v1.none'), '');
        }

        return $custodians;
    }

    public static function getUser($user_id)
    {
        $user = User::findOrFail($user_id);

        return $user;
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public function deleteSessionsFromOtherDevices()
    {
        $user = User::findOrFail($this->id);
        \DB::table('sessions')->where('user_id', $user->id)->delete();

        return true;
    }
}