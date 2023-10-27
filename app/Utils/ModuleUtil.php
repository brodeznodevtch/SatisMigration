<?php

namespace App\Utils;

use Illuminate\Http\Response;
use App\Models\BusinessLocation;
use App\Models\Product;
use App\Models\System;
use App\Models\Transaction;
use App\Models\User;
use Module;

class ModuleUtil extends Util
{
    /**
     * This function check if a module is installed or not.
     *
     * @param  string  $module_name (Exact module name, with first letter capital)
     */
    public function isModuleInstalled(string $module_name): bool
    {
        $is_available = Module::has($module_name);

        if ($is_available) {
            //Check if installed by checking the system table {module_name}_version
            $module_version = System::getProperty(strtolower($module_name).'_version');
            if (empty($module_version)) {
                return false;
            } else {
                return true;
            }
        }

        return false;
    }

    /**
     * This function check if superadmin module is installed or not.
     */
    public function isSuperadminInstalled(): bool
    {
        return $this->isModuleInstalled('Superadmin');
    }

    /**
     * This function check if a function provided exist in all modules
     * DataController, merges the data and returned it.
     */
    public function getModuleData(string $function_name): array
    {
        $modules = Module::toCollection()->toArray();

        $installed_modules = [];
        foreach ($modules as $module => $details) {
            if ($this->isModuleInstalled($details['name'])) {
                $installed_modules[] = $details;
            }
        }

        $data = [];
        if (! empty($installed_modules)) {
            foreach ($installed_modules as $module) {
                $class = 'Modules\\'.$module['name'].'\Http\Controllers\DataController';

                if (class_exists($class)) {
                    $class_object = new $class();
                    if (method_exists($class_object, $function_name)) {
                        $data[$module['name']] = call_user_func([$class_object, $function_name]);
                    }
                }
            }
        }

        return $data;
    }

    /**
     * Checks if a module is defined
     */
    public function isModuleDefined(string $module_name): bool
    {
        $is_installed = $this->isModuleInstalled($module_name);

        $check_for_enable = ['account'];

        $output = ! empty($version) ? true : false;

        if (in_array($module_name, $check_for_enable) &&
            ! $this->isModuleEnabled($module_name)) {
            $output = false;
        }

        return $output;
    }

    /**
     * This function check if a business has active subscription packages
     */
    public static function isSubscribed(int $business_id): bool
    {
        $is_available = Module::has('Superadmin');

        if ($is_available) {
            $package = \Modules\Superadmin\Entities\Subscription::active_subscription($business_id);

            if (empty($package)) {
                return false;
            }
        }

        return true;
    }

    /**
     * This function checks if a business has
     *
     * @param  string  $callback_function = null
     */
    public static function hasThePermissionInSubscription(int $business_id, string $permission, string $callback_function = null): bool
    {
        $is_available = Module::has('Superadmin');

        if ($is_available) {
            $package = \Modules\Superadmin\Entities\Subscription::active_subscription($business_id);

            if (empty($package)) {
                return false;
            } elseif (isset($package['package_details'][$permission])) {
                if (! is_null($callback_function)) {
                    $obj = new ModuleUtil();
                    $permissions = $obj->getModuleData($callback_function);

                    $permission_formatted = [];
                    foreach ($permissions as $per) {
                        foreach ($per as $details) {
                            $permission_formatted[$details['name']] = $details['label'];
                        }
                    }

                    if (isset($permission_formatted[$permission])) {
                        return $package['package_details'][$permission];
                    } else {
                        return false;
                    }
                } else {
                    return $package['package_details'][$permission];
                }
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns the name of view used to display for subscription expired.
     */
    public static function expiredResponse($redirect_url = null): string
    {
        $response_array = ['success' => 0,
            'msg' => __(
                'superadmin::lang.subscription_expired_toastr',
                ['app_name' => env('APP_NAME'), 'subscribe_url' => action([\Modules\Superadmin\Http\Controllers\SubscriptionController::class, 'index'])]
            ),
        ];

        if (request()->ajax()) {
            if (request()->wantsJson()) {
                return $response_array;
            } else {
                return view('superadmin::subscription.subscription_expired_modal');
            }
        } else {
            if (is_null($redirect_url)) {
                return back()
                    ->with('status', $response_array);
            } else {
                return redirect($redirect_url)
                    ->with('status', $response_array);
            }
        }
    }

    /**
     * This function check if a business has available quota for various types.
     */
    public static function isQuotaAvailable(string $type, int $business_id): bool
    {
        $is_available = Module::has('Superadmin');

        if ($is_available) {
            $package = \Modules\Superadmin\Entities\Subscription::active_subscription($business_id);

            if (empty($package)) {
                return false;
            }

            //Start
            $start_dt = $package->start_date->toDateTimeString();
            $end_dt = $package->end_date->endOfDay()->toDateTimeString();

            if ($type == 'locations') {
                //Check for available location and max number allowed.
                $max_allowed = isset($package->package_details['location_count']) ? $package->package_details['location_count'] : 0;
                if ($max_allowed == 0) {
                    return true;
                } else {
                    $count = BusinessLocation::where('business_id', $business_id)
                        ->count();
                    if ($count >= $max_allowed) {
                        return false;
                    }
                }
            } elseif ($type == 'users') {
                //Check for available location and max number allowed.
                $max_allowed = isset($package->package_details['user_count']) ? $package->package_details['user_count'] : 0;
                if ($max_allowed == 0) {
                    return true;
                } else {
                    $count = User::where('business_id', $business_id)
                        ->count();
                    if ($count >= $max_allowed) {
                        return false;
                    }
                }
            } elseif ($type == 'products') {
                $max_allowed = isset($package->package_details['product_count']) ? $package->package_details['product_count'] : 0;

                if ($max_allowed == 0) {
                    return true;
                } else {
                    $count = Product::where('business_id', $business_id)
                        ->whereBetween('created_at', [$start_dt, $end_dt])
                        ->count();
                    if ($count >= $max_allowed) {
                        return false;
                    }
                }
            } elseif ($type == 'invoices') {
                $max_allowed = isset($package->package_details['invoice_count']) ? $package->package_details['invoice_count'] : 0;

                if ($max_allowed == 0) {
                    return true;
                } else {
                    $count = Transaction::where('business_id', $business_id)
                        ->where('type', 'purchase')
                        ->whereBetween('created_at', [$start_dt, $end_dt])
                        ->count();
                    if ($count >= $max_allowed) {
                        return false;
                    }
                }
            }
        }

        return true;
    }

    /**
     * This function returns the response for expired quota
     *
     * @param  string  $redirect_url = null
     */
    public static function quotaExpiredResponse(string $type, int $business_id, string $redirect_url = null): Response
    {

        if ($type == 'locations') {
            if (request()->ajax()) {
                $count = BusinessLocation::where('business_id', $business_id)
                    ->count();

                if (request()->wantsJson()) {
                    $response_array = ['success' => 0,
                        'msg' => __('superadmin::lang.max_locations', ['count' => $count]),
                    ];

                    return $response_array;
                } else {
                    return view('superadmin::subscription.max_location_modal')
                        ->with('count', $count);
                }
            }
        } elseif ($type == 'users') {
            $count = User::where('business_id', $business_id)
                ->count();

            $response_array = ['success' => 0,
                'msg' => __('superadmin::lang.max_users', ['count' => $count]),
            ];

            return redirect($redirect_url)
                ->with('status', $response_array);
        } elseif ($type == 'products') {
            $count = Product::where('business_id', $business_id)
                ->count();

            $response_array = ['success' => 0,
                'msg' => __('superadmin::lang.max_products', ['count' => $count]),
            ];

            return redirect($redirect_url)
                ->with('status', $response_array);
        } elseif ($type == 'invoices') {
            $count = Transaction::where('business_id', $business_id)
                ->where('type', 'purchase')
                ->count();

            $response_array = ['success' => 0,
                'msg' => __('superadmin::lang.max_invoices', ['count' => $count]),
            ];

            if (request()->wantsJson()) {
                return $response_array;
            } else {
                return redirect($redirect_url)
                    ->with('status', $response_array);
            }
        }
    }

    public function accountsDropdown($business_id, $prepend_none = false, $closed = false)
    {

        $dropdown = [];

        if ($this->isModuleDefined('Account')) {
            $dropdown = \Modules\Account\Entities\Account::forDropdown($business_id, $prepend_none, $closed);
        }

        return $dropdown;
    }
}
