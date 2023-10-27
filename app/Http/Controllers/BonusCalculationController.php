<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\BonusCalculation;
use DataTables;
use DB;
use Illuminate\Http\Request;

class BonusCalculationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        if (! auth()->user()->can('payroll-catalogues.view')) {
            abort(403, 'Unauthorized action.');
        }

        return view('payroll.catalogues.bonus_calculation.index');
    }

    public function getBonusCalculations()
    {
        if (! auth()->user()->can('payroll-catolgues.view')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $data = DB::table('bonus_calculations as bc')
            ->select('bc.id as id', 'bc.from', 'bc.until', 'bc.days', 'bc.proportional', 'bc.status')
            ->where('bc.business_id', $business_id)
            ->where('bc.deleted_at', null)
            ->get();

        return DataTables::of($data)->editColumn('proportional', function ($data) {
            if ($data->proportional == 1) {
                return __('messages.yes');
            } else {
                return __('messages.no');
            }
        })->editColumn('status', function ($data) {
            if ($data->status == 1) {
                return __('rrhh.active');
            } else {
                return __('rrhh.inactive');
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

        $business_id = request()->session()->get('user.business_id');

        return view('payroll.catalogues.bonus_calculation.create');
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
            'from' => 'required|numeric',
            'until' => 'required|numeric',
            'days' => 'required|integer|min:0',
            'proportional' => 'required|boolean',
        ]);

        try {
            $input_details = $request->all();
            $input_details['business_id'] = request()->session()->get('user.business_id');

            DB::beginTransaction();

            BonusCalculation::create($input_details);

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
        $bonusCalculation = BonusCalculation::where('id', $id)->where('business_id', $business_id)->first();

        return view('payroll.catalogues.bonus_calculation.edit', compact('bonusCalculation'));
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
            'from' => 'required|numeric',
            'until' => 'required|numeric',
            'days' => 'required|integer|min:0',
            'proportional' => 'required|boolean',
        ]);

        try {
            $input_details = $request->all();
            $input_details['business_id'] = request()->session()->get('user.business_id');

            DB::beginTransaction();
            $business_id = request()->session()->get('user.business_id');
            $item = BonusCalculation::where('id', $id)->where('business_id', $business_id)->first();
            $bonusCalculation = $item->update($input_details);

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
                $item = BonusCalculation::where('id', $id)->where('business_id', $business_id)->first();
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
