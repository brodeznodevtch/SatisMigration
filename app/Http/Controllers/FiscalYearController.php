<?php

namespace App\Http\Controllers;

use App\Models\AccountingPeriod;
use App\Models\FiscalYear;
use DataTables;
use Illuminate\Http\Request;

class FiscalYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validateData = $request->validate(
            [
                'year' => 'required',
            ],
            [
                'year.required' => __('accounting.year_required'),
            ]
        );

        if ($request->ajax()) {

            $data = $request->all();
            $data['business_id'] = request()->session()->get('user.business_id');

            $year = FiscalYear::create($data);

            return response()->json([
                'msj' => 'Created',
            ]);

        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(FiscalYear $fiscalYear)
    {
        return response()->json($fiscalYear);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(FiscalYear $fiscalYear)
    {
        return response()->json($fiscalYear);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FiscalYear $fiscalYear)
    {
        $validateData = $request->validate(
            [
                'year' => 'required',
            ],
            [
                'year.required' => __('accounting.year_required'),
            ]
        );
        if ($request->ajax()) {
            $fiscalYear->update($request->all());

            return response()->json([
                'msj' => 'Updated',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(FiscalYear $fiscalYear)
    {
        if (request()->ajax()) {
            try {

                $periods = AccountingPeriod::where('fiscal_year_id', $fiscalYear->id)->count();

                if ($periods > 0) {
                    $output = [
                        'success' => false,
                        'msg' => __('accounting.year_has_periods'),
                    ];
                } else {
                    $fiscalYear->forceDelete();
                    $output = [
                        'success' => true,
                        'msg' => __('accounting.year_deleted'),
                    ];
                }
            } catch (\Exception $e) {
                $output = [
                    'success' => false,
                    'msg' => __('messages.something_went_wrong'),
                ];
            }

            return $output;
        }
    }

    public function getFiscalYearsData()
    {

        $business_id = request()->session()->get('user.business_id');

        $years = FiscalYear::select('id', 'year')
            ->where('business_id', $business_id)
            ->get();

        return DataTables::of($years)->toJson();
    }

    public function getYears()
    {

        $business_id = request()->session()->get('user.business_id');

        $years = FiscalYear::select('id', 'year')
            ->where('business_id', $business_id)
            ->get();

        return response()->json($years);
    }
}
