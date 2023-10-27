<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\InstitutionLaw;
use DataTables;
use DB;
use Illuminate\Http\Request;

class InstitutionLawController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        if (! auth()->user()->can('payroll-catalogues.view')) {
            abort(403, 'Unauthorized action.');
        }

        return view('payroll.catalogues.institution_laws.index');
    }

    public function getInstitutionLaws()
    {
        if (! auth()->user()->can('payroll-catolgues.view')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $data = DB::table('institution_laws as il')
            ->select('il.id as id', 'il.name', 'il.description', 'il.employeer_number')
            ->where('il.business_id', $business_id)
            ->where('il.deleted_at', null)
            ->get();

        return DataTables::of($data)
            ->editColumn('employeer_number', function ($data) {
                if ($data->employeer_number != null) {
                    return $data->employeer_number;
                } else {
                    return '---';
                }
            })->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        if (! auth()->user()->can('payroll-catalogues.create')) {
            abort(403, 'Unauthorized action.');
        }

        return view('payroll.catalogues.institution_laws.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! auth()->user()->can('payroll-catalogues.create')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'employeer_number' => 'nullable|regex:/^[0-9]+$/',
        ]);

        try {
            $input_details = $request->all();
            $input_details['business_id'] = request()->session()->get('user.business_id');
            DB::beginTransaction();

            InstitutionLaw::create($input_details);

            DB::commit();

            $output = [
                'success' => 1,
                'msg' => __('rrhh.added_successfully'),
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());
            $output = [
                'success' => 0,
                'msg' => __('rrhh.error'),
            ];
        }

        return $output;
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
        if (! auth()->user()->can('payroll-catalogues.edit')) {
            abort(403, 'Unauthorized action.');
        }
        $business_id = request()->session()->get('user.business_id');
        $institutionLaw = InstitutionLaw::where('id', $id)->where('business_id', $business_id)->first();

        return view('payroll.catalogues.institution_laws.edit', compact('institutionLaw'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        if (! auth()->user()->can('payroll-catalogues.edit')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'employeer_number' => 'nullable|regex:/^[0-9]+$/',
        ]);

        try {
            $input_details = $request->all();
            DB::beginTransaction();

            $business_id = request()->session()->get('user.business_id');
            $item = InstitutionLaw::where('id', $id)->where('business_id', $business_id)->first();
            $institutionLaw = $item->update($input_details);

            DB::commit();

            $output = [
                'success' => 1,
                'msg' => __('rrhh.updated_successfully'),
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());
            $output = [
                'success' => 0,
                'msg' => __('rrhh.error'),
            ];
        }

        return $output;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (! auth()->user()->can('payroll-catalogues.delete')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $business_id = request()->session()->get('user.business_id');
                $item = InstitutionLaw::where('id', $id)->where('business_id', $business_id)->first();
                $item->forceDelete();

                $output = [
                    'success' => true,
                    'msg' => __('rrhh.deleted_successfully'),
                ];
            } catch (\Exception $e) {
                \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());
                $output = [
                    'success' => false,
                    'msg' => __('rrhh.error'),
                ];
            }

            return $output;
        }
    }
}
