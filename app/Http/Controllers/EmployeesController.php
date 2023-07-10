<?php

namespace App\Http\Controllers;

use App\User;
use App\System;
use App\Employees;
use App\Positions;
use App\RrhhSalaryHistory;
use App\RrhhPositionHistory;
use App\Bank;
use App\Business;
use App\RrhhAbsenceInability;
use App\Notifications\NewNotification;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use DB;
use DataTables;
use Carbon\Carbon;
use Storage;
use Illuminate\Validation\Rule;
use App\Utils\ProductUtil;
use App\Utils\ModuleUtil;

class EmployeesController extends Controller
{
    protected $productUtil;
    protected $moduleUtil;

    /**
     * Constructor
     *
     * @param ProductUtil $product
     * @return void
     */
    public function __construct(ProductUtil $productUtil, ModuleUtil $moduleUtil)
    {
        $this->productUtil = $productUtil;
        $this->moduleUtil = $moduleUtil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        if(!auth()->user()->can('rrhh_employees.view') && !auth()->user()->can('employees.create')){
            abort(403, "Unauthorized action.");
        }
        return view('rrhh.employees.index');
    }


    //Mostrar Lista de Empleados
    public function getEmployees(){

        if ( !auth()->user()->can('rrhh_employees.view') ) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $data = DB::table('employees as e')
        ->select('e.id as id', 'e.agent_code', 'e.first_name', 'e.dni', 'e.email', 'e.status as status', DB::raw("CONCAT(e.first_name, ' ', e.last_name) as full_name"))
        ->where('e.business_id', $business_id)
        ->where('e.deleted_at', null)
        ->get();
        

        return DataTables::of($data)->editColumn('department', function ($data) {
            $position = RrhhPositionHistory::where('employee_id', $data->id)->where('current', 1)->first();
            return (!empty($position)) ? $position->newDepartment->value : __('rrhh.not_assigned');
        })->editColumn('position', function ($data) {
            $position = RrhhPositionHistory::where('employee_id', $data->id)->where('current', 1)->first();
            return (!empty($position)) ? $position->newPosition1->value : __('rrhh.not_assigned');
        })->editColumn('status', function ($data) {
            if($data->status == 1){
                return __('rrhh.active');
            }else{
                return __('rrhh.inactive');
            }
        })->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() 
    {
        if ( !auth()->user()->can('rrhh_employees.create') ) {
            abort(403, 'Unauthorized action.');
        }
        $business_id = request()->session()->get('user.business_id');

        $nationalities = DB::table('rrhh_datas')->where('rrhh_header_id', 6)->where('business_id', $business_id)->where('status', 1)->orderBy('value', 'ASC')->pluck('value', 'id');
        $civil_statuses = DB::table('rrhh_datas')->where('rrhh_header_id', 1)->where('business_id', $business_id)->where('status', 1)->orderBy('value', 'ASC')->pluck('value', 'id');
        $professions = DB::table('rrhh_datas')->where('rrhh_header_id', 7)->where('business_id', $business_id)->where('status', 1)->orderBy('value', 'ASC')->pluck('value', 'id');

        $departments = DB::table('rrhh_datas')->where('rrhh_header_id', 2)->where('business_id', $business_id)->where('status', 1)->orderBy('value', 'ASC')->pluck('value', 'id');
        $positions = DB::table('rrhh_datas')->where('rrhh_header_id', 3)->where('business_id', $business_id)->where('status', 1)->orderBy('value', 'ASC')->pluck('value', 'id');
        $afps = DB::table('rrhh_datas')->where('rrhh_header_id', 4)->where('business_id', $business_id)->where('status', 1)->orderBy('value', 'ASC')->pluck('value', 'id');
        $types = DB::table('rrhh_datas')->where('rrhh_header_id', 5)->where('business_id', $business_id)->where('status', 1)->orderBy('value', 'ASC')->pluck('value', 'id');
        $banks = Bank::where('business_id', $business_id)->orderBy('name', 'ASC')->pluck('name', 'id');
        $payments = DB::table('rrhh_datas')->where('rrhh_header_id', 8)->where('business_id', $business_id)->where('status', 1)->orderBy('value', 'ASC')->pluck('value', 'id');
        
        $countries = DB::table('countries')->pluck('name', 'id');
        
        $roles = DB::table('roles')
            ->select(DB::raw("left(roles.name,LOCATE('#', roles.name) - 1) as rol, id"))
            ->where('business_id', $business_id)
            ->orderBy('roles.name', 'asc')
            ->pluck('rol', 'id');

        return view('rrhh.employees.create', compact(
            'nationalities',
            'civil_statuses',
            'countries', 
            'professions',
            'departments',
            'positions',
            'afps',
            'types',
            'payments',
            'banks',
            'roles'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) 
    {
        if ( !auth()->user()->can('rrhh_employees.create') ) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'first_name'            => 'required',
            'last_name'             => 'required',
            'gender'                => 'required',
            'birth_date'            => 'required',
            'dni'                   => 'required|regex:/^\d{8}-\d$/',
            'tax_number'            => 'required',
            'address'               => 'required',
            'email'                 => 'required|email',
            'date_admission'        => 'nullable',
            'nationality_id'        => 'required', 
            'civil_status_id'       => 'required', 
            'department_id'         => 'required',
            'position1_id'          => 'required', 
            'salary'                => 'required|numeric|min:1',
            'payment_id'            => 'required',
        ]);

        try {
            $hasUser_mode = $request->input('chk_has_user');
            $commss_opt = $request->input('commission');

            if($hasUser_mode == 'has_user'){
                $password_mode = $request->input('rdb_pass_mode');

                $pass = $request->input('password');
                $password_mode = $request->input('rdb_pass_mode');
                $user_details = $request->only(['first_name', 'last_name', 'username', 'email', 'password']);
                $user_details['business_id'] = $request->session()->get('user.business_id');
                $user_details['status']      = 'pending';
                $user_details['language']    = 'es';

                if($password_mode == 'generated'){
                    $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
                    $password = "";
                    for($i = 0; $i < 9; $i ++){
                        $password .= substr($str, rand(0,61), 1);
                    }
                    $user_details['password'] = bcrypt($password);
                }else{
                    $password = $request->input('password');
                    $user_details['password'] = bcrypt($user_details['password']);
                }

                $ref_count = $this->moduleUtil->setAndGetReferenceCount('username');
                if(blank($user_details['username'])){
                    $user_details['username'] = $this->moduleUtil->generateReferenceNumber('username', $ref_count);
                }

                $username_ext = $this->getUsernameExtension();
                if(!empty($username_ext)){
                    $user_details['username'] .= $username_ext;
                }

                if($commss_opt == 'has_commission'){
                    $user_details['is_cmmsn_agnt'] = 1;
                    $user_details['cmmsn_percent'] = $request->input('commision_amount');
                }else{
                    $user_details['is_cmmsn_agnt'] = 0;
                }

                DB::beginTransaction();
                $user_details = User::create($user_details);
                $user_id = $user_details->id;
                $role_id = $request->input('role');
                $role = Role::findOrFail($role_id);
                $user_details->assignRole($role->name);
                $user_details->notify(new NewNotification($password));
            }

            $input_details = $request->only([
                'first_name', 
                'last_name', 
                'username', 
                'email',
                'last_name',
                'gender',
                'nationality_id',
                'dni',
                'tax_number',
                'civil_status_id',
                'phone',
                'mobile',
                'email',
                'address',
                'social_security_number',
                'afp_id',
                'afp_number',
                'payment_id',
                'bank_id',
                'bank_account'
            ]);
            $input_details['birth_date']     = $this->moduleUtil->uf_date($request->input('birth_date'));
            $input_details['date_admission'] = $this->moduleUtil->uf_date($request->input('date_admission'));

            $input_details['photo']          = $this->productUtil->uploadFile($request, 'photo', config('constants.product_img_path'));
            $input_details['created_by']     = $request->session()->get('user.id');
            $input_details['business_id']    = $request->session()->get('user.business_id');
            $employee = Employees::create($input_details);

            RrhhPositionHistory::insert(
                ['new_department_id' => $request->input('department_id'), 'new_position1_id' => $request->input('position1_id'), 'employee_id' => $employee->id, 'current' => 1]
            );

            RrhhSalaryHistory::insert(
                ['employee_id' => $employee->id, 'new_salary' => $request->input('salary'), 'current' => 1]
            );

            DB::commit();

            $output = [
                'success' => 1,
                'id' => $employee->id,
                'msg' => __('rrhh.added_successfully')
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            $output = [
                'success' => 0,
                'msg' => __('rrhh.error')
            ];
        }

        if ($request->input('submit_type') == 'complete') {
            return redirect()->action('EmployeesController@edit', [$employee->id]);
        } else if ($request->input('submit_type') == 'other') {
            return redirect()->action('EmployeesController@create')->with('status', $output);
        } else {
            return redirect('rrhh-employees')->with('status', $output);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employees  $humanResourceEmployee
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        if ( !auth()->user()->can('rrhh_employees.view') ) {
            abort(403, 'Unauthorized action.');
        }

        $employee = Employees::where('id', $id)->with(
            'afp',
            'civilStatus',
            'nationality',
            'profession',
            'type',
            'bank',
            'city',
            'state'
        )
        ->first();

        if ($employee->photo == '') {
            if($employee->gender == 'F'){
                $route = 'uploads/img/avatar_F.png';
            }else{
                $route = 'uploads/img/avatar_M.png';
            }
        } else {
            $route = 'uploads/img/'.$employee->photo;
        }

        $business_id = request()->session()->get('user.business_id');
        $business = Business::where('id', $business_id)->first();

        $positions = RrhhPositionHistory::where('employee_id', $employee->id)->orderBy('id', 'DESC')->get();
        $salaries = RrhhSalaryHistory::where('employee_id', $employee->id)->orderBy('id', 'DESC')->get();
        $documents = DB::table('rrhh_documents as document')
        ->join('rrhh_datas as type', 'type.id', '=', 'document.document_type_id')
        ->join('states as state', 'state.id', '=', 'document.state_id')
        ->join('cities as city', 'city.id', '=', 'document.city_id')
        ->select('document.id as id', 'type.value as type', 'state.name as state', 'city.name as city', 'document.number as number', 'document.file as file', 'document.document_type_id as document_type_id', 'document.date_expedition as date_expedition', 'document.date_expiration as date_expiration')
        ->where('document.employee_id', $id)
        ->get();

        $economicDependences = DB::table('rrhh_economic_dependences as economicDependence')
        ->join('rrhh_datas as type', 'type.id', '=', 'economicDependence.type_relationship_id')
        ->join('employees as employee', 'employee.id', '=', 'economicDependence.employee_id')
        ->select('economicDependence.id as id', 'type.value as type', 'economicDependence.name as name', 'economicDependence.birthdate as birthdate', 'economicDependence.phone as phone', 'economicDependence.status as status')
        ->where('economicDependence.employee_id', $employee->id)
        ->where('type.rrhh_header_id', 15)
        ->get();

        $absenceInabilities = RrhhAbsenceInability::where('employee_id', $employee->id)->get();

        $personnelActions = DB::table('rrhh_personnel_actions as personnel_action')
            ->join('rrhh_type_personnel_actions as type', 'type.id', '=', 'personnel_action.rrhh_type_personnel_action_id')
            ->select('personnel_action.id as id', 'personnel_action.description as description', 'personnel_action.created_at as created_at', 'type.name as type', 'type.required_authorization as required_authorization', 'personnel_action.status as status')
            ->where('personnel_action.employee_id', $employee->id)
            ->get();

        return view('rrhh.employees.show', compact('employee', 'route', 'documents', 'positions', 'salaries', 'business', 'economicDependences', 'absenceInabilities', 'personnelActions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employees  $humanResourceEmployee
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        if ( !auth()->user()->can('rrhh_employees.update') ) {
            abort(403, 'Unauthorized action.');
        }

        $employee = Employees::findOrFail($id);
        $position = RrhhPositionHistory::where('employee_id', $employee->id)->where('current', 1)->get();
        $salary = RrhhSalaryHistory::where('employee_id', $employee->id)->where('current', 1)->get();
        $business_id = request()->session()->get('user.business_id');

        $nationalities = DB::table('rrhh_datas')->where('rrhh_header_id', 6)->where('business_id', $business_id)->where('status', 1)->orderBy('value', 'ASC')->pluck('value', 'id');
        $civil_statuses = DB::table('rrhh_datas')->where('rrhh_header_id', 1)->where('business_id', $business_id)->where('status', 1)->orderBy('value', 'ASC')->pluck('value', 'id');
        $professions = DB::table('rrhh_datas')->where('rrhh_header_id', 7)->where('business_id', $business_id)->where('status', 1)->orderBy('value', 'ASC')->pluck('value', 'id');
        $departments = DB::table('rrhh_datas')->where('rrhh_header_id', 2)->where('business_id', $business_id)->where('status', 1)->orderBy('value', 'ASC')->pluck('value', 'id');
        $positions = DB::table('rrhh_datas')->where('rrhh_header_id', 3)->where('business_id', $business_id)->where('status', 1)->orderBy('value', 'ASC')->pluck('value', 'id');
        $afps = DB::table('rrhh_datas')->where('rrhh_header_id', 4)->where('business_id', $business_id)->where('status', 1)->orderBy('value', 'ASC')->pluck('value', 'id');
        $types = DB::table('rrhh_datas')->where('rrhh_header_id', 5)->where('business_id', $business_id)->where('status', 1)->orderBy('value', 'ASC')->pluck('value', 'id');
        $payments = DB::table('rrhh_datas')->where('rrhh_header_id', 8)->where('business_id', $business_id)->where('status', 1)->orderBy('value', 'ASC')->pluck('value', 'id');
        $banks = Bank::where('business_id', $business_id)->orderBy('name', 'ASC')->pluck('name', 'id');
        $countries = DB::table('countries')->pluck('name', 'id');
        $states = DB::table('states')->where('country_id', $employee->country_id)->pluck('name', 'id');
        $cities = DB::table('cities')->where('state_id', $employee->state_id)->pluck('name', 'id');
        
        $documents = DB::table('rrhh_documents as document')
        ->join('rrhh_datas as type', 'type.id', '=', 'document.document_type_id')
        ->join('states as state', 'state.id', '=', 'document.state_id')
        ->join('cities as city', 'city.id', '=', 'document.city_id')
        ->select('document.id as id', 'type.value as type', 'state.name as state', 'city.name as city', 'document.number as number', 'document.file as file', 'document.document_type_id as document_type_id', 'document.date_expedition as date_expedition', 'document.date_expiration as date_expiration')
        ->where('document.employee_id', $employee->id)
        ->get();

        $type_documents = DB::table('rrhh_datas')->where('rrhh_header_id', 9)->where('business_id', $business_id)->where('status', 1)->orderBy('value', 'DESC')->get();
        
       
        for ($i=0; $i < count($documents); $i++) { 
            if(isset($type_documents)){
                if(!empty($type_documents)){
                    for ($j=0; $j < count($type_documents); $j++) {
                        if($type_documents[$j]->id == $documents[$i]->document_type_id){
                            $type_documents[$j]->value = '';
                        }
                    }
                }
            }
        }
    
        return view('rrhh.employees.edit', compact(
            'employee',
            'nationalities',
            'civil_statuses',
            'states', 
            'professions',
            'departments',
            'positions',
            'afps',
            'types',
            'banks',
            'cities',
            'payments',
            'countries',
            'documents',
            'type_documents',
            'position',
            'salary'
        ));        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employees  $humanResourceEmployee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        if ( !auth()->user()->can('rrhh_employees.update') ) {
            abort(403, 'Unauthorized action.');
        }
        $employee = Employees::findOrFail($id);
        $position = RrhhPositionHistory::where('employee_id', $employee->id)->where('current', 1)->get();
        $salary = RrhhSalaryHistory::where('employee_id', $employee->id)->where('current', 1)->get();

        $requiredDepartment = 'nullable';
        $requiredPosition = 'nullable';
        $requiredSalary = 'nullable';
        $requiredPayment = 'nullable';
        if(count($position) == 0){
            $requiredDepartment = 'required';
            $requiredPosition = 'required';
        }

        if(count($salary) == 0){
            $requiredSalary = 'required|numeric|min:1';
        }

        if($employee->payment_id == null){
            $requiredPayment = 'required';
        }

        $request->validate([
            'first_name'            => 'required',
            'last_name'             => 'required',
            'gender'                => 'required',
            'birth_date'            => 'required',
            'dni'                   => 'required|regex:/^\d{8}-\d$/',
            'tax_number'            => 'required',
            'address'               => 'required',
            'email'                 => 'required|email',
            'date_admission'        => 'nullable',
            'nationality_id'        => 'required', 
            'civil_status_id'       => 'required', 
            'department_id'         => $requiredDepartment,
            'position1_id'          => $requiredPosition, 
            'salary'                => $requiredSalary,
            'payment_id'            => $requiredPayment,
            'afp_number'            => 'nullable|integer',
            'social_security_number'=> 'nullable|integer',
        ]);

        try {
            $input_details = $request->only([
                'first_name', 
                'last_name', 
                'username', 
                'email',
                'last_name',
                'gender',
                'nationality_id',
                'dni',
                'tax_number',
                'civil_status_id',
                'phone',
                'mobile',
                'email',
                'address',
                'social_security_number',
                'afp_id',
                'afp_number',
                'payment_id',
                'bank_id',
                'bank_account',
                'date_admission',
                'photo',
                'status',
                'country_id',
                'profession_id',
                'type_id',
                'payment_id',
                'bank_id',
                'bank_account',
                'state_id',
                'city_id'
            ]);

            if ($request->input('status')) {
                $input_details['status'] = 1;
            } else {
                $input_details['status'] = 0;
            }
            
            if ($request->hasFile('photo')) {
                $input_details['photo'] = $this->productUtil->uploadFile($request, 'photo', config('constants.product_img_path'));
            }
            
            $input_details['date_admission'] = $this->moduleUtil->uf_date($request->input('date_admission'));
            $input_details['birth_date']     = $this->moduleUtil->uf_date($request->input('birth_date'));     
            if ($employee->payment_id == null){
                $input_details['payment_id']   = $request->input('payment_id');
                $input_details['bank_id']      = $request->input('bank_id');
                $input_details['bank_account'] = $request->input('bank_account');
            }

            $mdate = Carbon::parse($input_details['date_admission'])->format('n');
            $ydate = Carbon::parse($input_details['date_admission'])->format('Y');
            $last_correlative = DB::table('employees')
                ->select(DB::raw('MAX(id) as max'))
                ->first();
            if ($last_correlative->max != null) {
                $correlative = $last_correlative->max + 1;

            } else {
                $correlative = 1;
            }
            
            if($employee->agent_code == null){
                $input_details['agent_code']     = 'E'.$mdate.$ydate.str_pad($correlative, 3, '0', STR_PAD_LEFT);
            }
            $employee->update($input_details);

            if(count($position) == 0){
                RrhhPositionHistory::insert(
                    ['new_department_id' => $request->input('department_id'), 'new_position1_id' => $request->input('position1_id'), 'employee_id' => $employee->id, 'current' => 1]
                );
            }

            if(count($salary) == 0){
                RrhhSalaryHistory::insert(
                    ['employee_id' => $employee->id, 'new_salary' => $request->input('salary'), 'current' => 1]
                );
            }

            $output = [
                'success' => 1,
                'msg' => __('rrhh.updated_successfully')
            ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            $output = [
                'success' => 0,
                'msg' => $e->getMessage()
            ];
        }
        return redirect('rrhh-employees')->with('status', $output);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employees  $humanResourceEmployee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) 
    {
        if (!auth()->user()->can('rrhh_employees.delete')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $item = Employees::findOrFail($id);

                $item->delete();
                $output = [
                    'success' => true,
                    'msg' => __('rrhh.deleted_successfully')
                ];
            }
            catch (\Exception $e){
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
                $output = [
                    'success' => false,
                    'msg' => __('rrhh.error')
                ];
            }
            return $output;
        }
    }


    public function verifiedIfExistsDocument($type, $value, $id = null)
    {
        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');

            //verifica si hay registtos en la base de datos
            if ($type == 'dni') {
                if(is_null($id)){
                    $employee = Employees::where('dni', $value)->where('business_id', $business_id)->exists();
                }else{
                    $employee = Employees::where('id', '<>', $id)->where('dni', $value)->where('business_id', $business_id)->exists();
                }
                if ($employee) {
                    $output = [
                        'success' => true,
                        'msg' => trans('customer.DNI_invalid')
                    ];
                    return  $output;
                } 
            } else if ($type == 'tax_number') {
                if(is_null($id)){
                    $employee = Employees::where('tax_number', $value)->where('business_id', $business_id)->exists();
                }else{
                    $employee = Employees::where('id', '<>', $id)->where('tax_number', $value)->where('business_id', $business_id)->exists();
                }
                if ($employee) {
                    $output2 = [
                        'success' => true,
                        'msg' => trans('customer.validate_tax_number_error')
                    ];
                    return  $output2;
                }
            }
        }
    }

    public function getPhoto($id) {

        if($id != null){
            if ( !auth()->user()->can('rrhh_employees.view') ) {
                abort(403, 'Unauthorized action.');
            }
    
            $employee = Employees::findOrFail($id);
            if ($employee->photo == null) {
                $route = 'uploads/img/defualt.png';
            } else {
                $route = 'uploads/img/'.$employee->photo;
            }
    
            return view('rrhh.employees.photo', compact('route'));
        }
    }

    private function getUsernameExtension()
    {
        $extension = !empty(System::getProperty('enable_business_based_username')) ? '-' .str_pad(session()->get('business.id'), 2, 0, STR_PAD_LEFT) : null;
        return $extension;
    }
}