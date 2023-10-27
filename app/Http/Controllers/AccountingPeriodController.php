<?php

namespace App\Http\Controllers;

use App\Models\AccountingEntrie;
use App\Models\AccountingPeriod;
use DataTables;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AccountingPeriodController extends Controller
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
     */
    public function store(Request $request): JsonResponse
    {

        $validateData = $request->validate(
            [
                'name' => 'required',
                'fiscal_year_id' => 'required',
                'month' => 'required',
            ],
            [
                'name.required' => __('accounting.name_required'),
                'fiscal_year_id.required' => __('accounting.fiscal_year_id_required'),
                'month.required' => __('accounting.month_required'),
            ]
        );

        if ($request->ajax()) {

            $data = $request->all();
            $data['business_id'] = request()->session()->get('user.business_id');

            $period = AccountingPeriod::create($data);

            return response()->json([
                'msj' => 'Created',
            ]);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AccountingPeriod $accountingPeriod): JsonResponse
    {

        return response()->json($accountingPeriod);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AccountingPeriod $accountingPeriod): JsonResponse
    {

        return response()->json($accountingPeriod);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccountingPeriod $accountingPeriod): JsonResponse
    {

        $validateData = $request->validate(
            [
                'name' => 'required',
                'fiscal_year_id' => 'required',
                'month' => 'required',
            ],
            [
                'name.required' => __('accounting.name_required'),
                'fiscal_year_id.required' => __('accounting.fiscal_year_id_required'),
                'month.required' => __('accounting.month_required'),
            ]
        );

        if ($request->ajax()) {

            $accountingPeriod->update($request->all());

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
    public function destroy(AccountingPeriod $accountingPeriod)
    {

        if (request()->ajax()) {
            try {

                $entries = AccountingEntrie::where('accounting_period_id', $accountingPeriod->id)->count();

                if ($entries > 0) {

                    $output = [
                        'success' => false,
                        'msg' => __('accounting.period_has_entries'),
                    ];

                } else {

                    $accountingPeriod->forceDelete();
                    $output = [
                        'success' => true,
                        'msg' => __('accounting.period_deleted'),
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

    public function getPeriodsData()
    {

        $business_id = request()->session()->get('user.business_id');
        $year = request()->get('year', null);

        $periods = DB::table('accounting_periods')
            ->join('fiscal_years', 'fiscal_years.id', '=', 'accounting_periods.fiscal_year_id')
            ->select('accounting_periods.*', 'fiscal_years.year')
            ->where('accounting_periods.business_id', $business_id);

        if (! empty($year)) {
            $periods->where('fiscal_years.id', $year);
        }

        $periods = $periods->get();

        return DataTables::of($periods)->toJson();
    }

    public function getPeriodStatus($id)
    {

        $period = AccountingPeriod::select('status')
            ->where('id', $id)
            ->first();

        return $period->status;
    }
}
