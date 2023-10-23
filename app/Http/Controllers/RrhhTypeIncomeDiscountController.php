<?php

namespace App\Http\Controllers;

use App\BusinessLocation;
use App\Catalogue;
use App\RrhhIncomeDiscount;
use Illuminate\Http\Request;
use App\RrhhTypeIncomeDiscount;
use App\RrhhTypeIncomeDiscountLocation;
use DB;
use DataTables;

class RrhhTypeIncomeDiscountController extends Controller
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
    public function getTypeIncomeDiscountData() {

        if ( !auth()->user()->can('rrhh_catalogues.view') ) {
            abort(403, 'Unauthorized action.');
        }

        $business_id =  request()->session()->get('user.business_id');
        $data = DB::table('rrhh_type_income_discounts')
        ->select('rrhh_type_income_discounts.*')
        ->where('rrhh_type_income_discounts.business_id', $business_id)
        ->where('rrhh_type_income_discounts.deleted_at', null);

        return DataTables::of($data)
        ->addColumn(
            'type',
            function ($row) {
                if ($row->type == 1) {

                    $html = __('rrhh.income');
                } else {

                    $html = __('rrhh.discount');
                }
                return $html;
            }
        )->addColumn(
            'status',
            function ($row) {
                if ($row->status == 1) {

                    $html = 'Activo';
                } else {

                    $html = 'Inactivo';
                }
                return $html;
            }
        )->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        if ( !auth()->user()->can('rrhh_catalogues.create') ) {
            abort(403, 'Unauthorized action.');
        }        

        $payrollColumns = RrhhTypeIncomeDiscount::$payrollColumns;
        $business_id = request()->session()->get('user.business_id');

        $accounts = Catalogue::with('padre')
            ->where('business_id', $business_id)
            ->where('status', 1)
            ->whereNOTIn('id', [DB::raw("select parent from catalogues")])
            ->orderBy('code', 'asc')
            ->get();
        $locations = BusinessLocation::select("name", "id")->where('business_id', $business_id)->get();

        return view('rrhh.catalogues.types_income_discounts.create', compact('payrollColumns', 'accounts', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {      
        if ( !auth()->user()->can('rrhh_catalogues.create') ) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name'           => 'required',     
            'type'           => 'required',
            'payroll_column' => 'required',  
            //'catalogues'     => 'required', 
            //'locations'      => 'required', 
            'catalogue_id'   => 'required',
            'concept'        => 'required',          
        ]);

        
        try {
            $input_details = $request->all();
            $payrollColumns = RrhhTypeIncomeDiscount::$payrollColumns;
            for ($i=0; $i < count($payrollColumns); $i++) { 
                if($request->payroll_column == $i){
                    $input_details['payroll_column'] = $payrollColumns[$i];
                }
            }

            $input_details['business_id'] =  request()->session()->get('user.business_id');

            $type = RrhhTypeIncomeDiscount::create($input_details);

            // $locations = $request->input('locations');
            // $catalogues = $request->input('catalogues');
            // for($i = 0; $i < count($locations); $i++){
            //     $details['rrhh_type_income_discount_id'] = $type->id;
            //     $details['business_location_id'] = $locations[$i];
            //     $details['catalogue_id'] = $catalogues[$i];
            //     RrhhTypeIncomeDiscountLocation::create($details);
            // }

            $output = [
                'success' => true,
                'msg' => __('rrhh.added_successfully')
            ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            $output = [
                'success' => false,
                'msg' => __('rrhh.error')
            ];
        }
        return $output;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RrhhTypeIncomeDiscount  $rrhhTypeWage
     * @return \Illuminate\Http\Response
     */
    public function show(RrhhTypeIncomeDiscount $rrhhTypeWage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RrhhTypeIncomeDiscount  $rrhhTypeWage
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        if ( !auth()->user()->can('rrhh_catalogues.update') ) {
            abort(403, 'Unauthorized action.');
        }

        $payrollColumns = RrhhTypeIncomeDiscount::$payrollColumns;
        $item = RrhhTypeIncomeDiscount::findOrFail($id);
        $business_id = request()->session()->get('user.business_id');

        $accounts = Catalogue::with('padre')
            ->where('business_id', $business_id)
            ->where('status', 1)
            ->whereNOTIn('id', [DB::raw("select parent from catalogues")])
            ->orderBy('code', 'asc')
            ->get();
        
    
        $locations = BusinessLocation::select("name", "id")->where('business_id', $business_id)->get();
        
        return view('rrhh.catalogues.types_income_discounts.edit', compact('payrollColumns', 'item', 'accounts', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RrhhTypeIncomeDiscount  $rrhhTypeWage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        if ( !auth()->user()->can('rrhh_catalogues.update') ) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required',     
            'type' => 'required',
            'payroll_column' => 'required',  
            // 'catalogues'     => 'required', 
            // 'locations'      => 'required',
            'catalogue_id'   => 'required', 
            'concept'        => 'required',         
        ]);

        try {
            $input_details = $request->all();
            $payrollColumns = RrhhTypeIncomeDiscount::$payrollColumns;
            for ($i=0; $i < count($payrollColumns); $i++) { 
                if($request->payroll_column == $i){
                    $input_details['payroll_column'] = $payrollColumns[$i];
                }
            }            

            $item = RrhhTypeIncomeDiscount::findOrFail($id);
            $item->update($input_details);

            // $locations = $request->input('locations');
            // $catalogues = $request->input('catalogues');
            // for($i = 0; $i < count($locations); $i++){
            //     $details['rrhh_type_income_discount_id'] = $item->id;
            //     $details['business_location_id'] = $locations[$i];
            //     $details['catalogue_id'] = $catalogues[$i];
            //     RrhhTypeIncomeDiscountLocation::create($details);
            // }

            $output = [
                'success' => true,
                'msg' => __('rrhh.updated_successfully')
            ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            $output = [
                'success' => 0,
                'msg' => __('rrhh.error')
            ];
        }
        return $output;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RrhhTypeIncomeDiscount  $rrhhTypeWage
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        if (!auth()->user()->can('rrhh_catalogues.delete')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {

            try {
                $count = RrhhIncomeDiscount::where('rrhh_type_income_discount_id', $id)->count();

                if ($count > 0) {
                    $output = [
                        'success' => false,
                        'msg' => __('rrhh.item_has_childs')
                    ];
                } else {
                    $item = RrhhTypeIncomeDiscount::findOrFail($id);
                    $item->delete();
                    $output = [
                        'success' => true,
                        'msg' => __('rrhh.deleted_successfully')
                    ];
                }               
            }
            catch (\Exception $e){
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
                $output = [
                    'success' => false,
                    'msg' => $e->getMessage()
                ];
            }
            return $output;
        }
    }

    public function getAccountingAccount()
    {
        if (request()->ajax()) {
            $term = request()->q;
            if (empty($term)) {
                return json_encode([]);
            }

            $business_id = request()->session()->get('user.business_id');
            
                $cities = City::where('business_id', $business_id)
                ->where('name', 'LIKE', '%'.$term.'%')
                ->select('id','name as text')
                ->get();
    
                return json_encode($cities);
            
        }        
    }
}
