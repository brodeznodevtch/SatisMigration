<?php

namespace App\Http\Controllers;

use App\Models\CRMContactMode;
use App\Utils\ModuleUtil;
use DB;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class CRMContactModeController extends Controller
{
    public function __construct(ModuleUtil $moduleUtil)
    {
        $this->moduleUtil = $moduleUtil;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        if (! auth()->user()->can('crm-contactmode.view') && ! auth()->user()->can('crm-contactmode.create')) {
            abort(403, 'Unauthorized action.');
        }
        $business_id = request()->session()->get('user.business_id');

        return view('crm_contact_mode.index');
    }

    public function getContactModeData()
    {
        if (! auth()->user()->can('crm-contactmode.view') && ! auth()->user()->can('crm-contactmode.create')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $contact_mode = DB::table('crm_contact_modes')
            ->select('crm_contact_modes.name', 'crm_contact_modes.description', 'crm_contact_modes.id')
            ->where('business_id', $business_id);

        return DataTables::of($contact_mode)
            ->addColumn(
                'action',
                '@can("crm-contactmode.update")
            <button data-href="{{action(\'CRMContactModeController@edit\', [$id])}}" class="btn btn-xs btn-primary edit_contactmode_button"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")</button>
                &nbsp;
            @endcan
            @can("crm-contactmode.delete")
                <button data-href="{{action(\'CRMContactModeController@destroy\', [$id])}}" class="btn btn-xs btn-danger delete_contactmode_button"><i class="glyphicon glyphicon-trash"></i> @lang("messages.delete")</button>
            @endcan'
            )
            ->removeColumn('id')
            ->rawColumns([2])
            ->make(false);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        if (! auth()->user()->can('crm-contactmode.create')) {
            abort(403, 'Unauthorized action.');
        }

        return view('crm_contact_mode.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! auth()->user()->can('crm-contactmode.create')) {
            abort(403, 'Unauthorized action.');
        }
        try {
            $contact_mode = $request->only(['name', 'description']);
            $contact_mode['business_id'] = $request->session()->get('user.business_id');

            $contact_mode = CRMContactMode::create($contact_mode);
            $outpout = ['success' => true,
                'data' => $contact_mode,
                'msg' => __('crm.added_success')];
        } catch (\Exception $e) {
            \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());
            $outpout = ['success' => false, 'msg' => $e->getMessage()];
        }

        return $outpout;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        if (! auth()->user()->can('crm-contactmode.update')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');
            $contact_mode = CRMContactMode::where('business_id', $business_id)->find($id);

            return view('crm_contact_mode.edit')
                ->with(compact('contact_mode'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        if (! auth()->user()->can('crm-contactmode.update')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $input = $request->only(['name', 'description']);
                $business_id = $request->session()->get('user.business_id');

                $contact_mode = CRMContactMode::where('business_id', $business_id)->findOrFail($id);
                $contact_mode->name = $input['name'];
                $contact_mode->description = $input['description'];
                $contact_mode->save();

                $outpout = ['success' => true, 'data' => $contact_mode, 'msg' => __('crm.updated_success')];
            } catch (\Exception $e) {
                \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());
                $outpout = ['success' => false, 'msg' => $e->getMessage()];
            }

            return $outpout;

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (! auth()->user()->can('crm-contactmode.delete')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $business_id = request()->session()->get('user.business_id');
                $contact_mode = CRMContactMode::where('business_id', $business_id)->find($id);

                $contact_mode->delete();
                $outpout = ['success' => true, 'data' => $contact_mode, 'msg' => __('crm.deleted_success')];
            } catch (\Exception $e) {
                \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());
                $outpout = ['success' => false, 'msg' => $e->getMessage()];
            }

            return $outpout;
        }
    }
}
