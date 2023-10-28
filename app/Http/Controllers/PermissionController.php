<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use DataTables;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        if (! auth()->user()->can('permission.view')) {
            abort(403, 'Unauthorized action.');
        }

        return view('modules.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        if (! auth()->user()->can('permission.view')) {
            abort(403, 'Unauthorized action.');
        }

        return view('modules.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! auth()->user()->can('permission.create')) {
            abort(403, 'Unauthorized action.');
        }
        try {
            $permission = Permission::create($request->all());
            $output = [
                'success' => true,
                'msg' => __('role.permission_added'),
            ];
        } catch (\Exception $e) {
            \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return $output;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show(Permission $permission): JsonResponse
    {
        if (! auth()->user()->can('permission.view')) {
            abort(403, 'Unauthorized action.');
        }

        return response()->json($permission);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit(Permission $permission): JsonResponse
    {
        if (! auth()->user()->can('permission.update')) {
            abort(403, 'Unauthorized action.');
        }

        return response()->json($permission);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        if (! auth()->user()->can('permission.update')) {
            abort(403, 'Unauthorized action.');
        }
        try {
            $permission->name = $request->input('name');
            $permission->description = $request->input('description');
            $permission->module_id = $request->input('module_id');
            $permission->save();
            $output = [
                'success' => true,
                'msg' => __('role.permission_updated'),
            ];
        } catch (\Exception $e) {
            \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return $output;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        if (! auth()->user()->can('permission.delete')) {
            abort(403, 'Unauthorized action.');
        }
        try {
            $count = DB::table('role_has_permissions')
                ->where('permission_id', $permission->id)
                ->count();
            if ($count > 0) {
                $output = [
                    'success' => false,
                    'msg' => __('role.role_has_permissions'),
                ];
            } else {
                $permission->delete();
                $output = [
                    'success' => true,
                    'msg' => __('role.permission_deleted'),
                ];
            }
        } catch (\Exception $e) {
            \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return $output;
    }

    public function getPermissionsData()
    {
        $permissions = DB::table('permissions as permission')
            ->leftJoin('modules as module', 'module.id', '=', 'permission.module_id')
            ->select('permission.*', 'module.name as module')
            ->where('permission.deleted_at', null)
            ->where('module.deleted_at', null)
            ->where('module.status', 1);

        return DataTables::of($permissions)->toJson();
    }

    public function getPermissionsNoExist()
    {
        $permissions = Permission::checkPermissions();

        dd($permissions);
    }

    public function getRegisterPermissions()
    {
        Permission::registerPermissions();

        return 'SUCCESS';
    }
}
