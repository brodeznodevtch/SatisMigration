<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Business;
use App\Models\Module;
use DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class ImplementationController extends Controller
{
    public function index(): View
    {
        // if(!auth()->user()->can('business_settings.access_module')){
        //     abort(403, "Unauthorized action.");
        // }
        // if (! (auth()->user()->hasRole('Super Admin#'.request()->session()->get('user.business_id')) || auth()->user()->hasRole('Implementaciones#'.request()->session()->get('user.business_id')))) {
        //     abort(403, 'Unauthorized action.');
        // }

        $systemModules = Module::orderBy('name', 'ASC')->get();
        $avlble_modules = [];
        $enabled = [];
        foreach ($systemModules as $systemModule) {
            $avlble_modules[$systemModule->name] = ['name' => $systemModule->name, 'id' => $systemModule->id, 'description' => $systemModule->description, 'status' => $systemModule->status];
            if ($systemModule->status == 1) {
                $enabled[] = $systemModule->name;
            }
        }

        $modules = $avlble_modules;

        return view('implementations.index', compact('modules', 'enabled'));
    }

    public function store(Request $request): RedirectResponse
    {
        // if (! auth()->user()->can('business_settings.access_module')) {
        //     abort(403, 'Unauthorized action.');
        // }

        try {
            //dd($request->enabled_modules);
            DB::beginTransaction();

            $business_id = request()->session()->get('user.business_id');
            $business = Business::where('id', $business_id)->first();

            //Enabled modules
            $enabled_modules = $request->input('enabled_modules');
            $business_details['enabled_modules'] = $enabled_modules;
            $business->fill($business_details);
            $business->save();

            $modules = Module::all();
            foreach ($modules as $module) {
                if (in_array($module->name, $enabled_modules)) {
                    $module->status = 1;
                } else {
                    $module->status = 0;

                    $roles = Role::where('roles.business_id', '=', $business_id)->get();

                    foreach ($roles as $role) {
                        if ($role->permissions) {
                            foreach ($role->permissions as $permission) {
                                if ($permission->module_id == $module->id) {
                                    if ($role->hasPermissionTo($permission)) {
                                        $role->revokePermissionTo($permission);
                                    }
                                }
                            }
                        }
                    }
                }
                $module->update();
            }

            DB::commit();

            $output = [
                'success' => 1,
                'msg' => __('business.settings_updated_module_success'),
            ];

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::emergency('File: '.$e->getFile().' Line: '.$e->getLine().' Message: '.$e->getMessage());

            $output = [
                'success' => 0,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return redirect('implementations')->with('status', $output);
    }
}
