<?php

namespace App\Http\Controllers;

use App\Business;
use App\CalculationType;
use App\Employees;
use App\Exports\PayrollSalaryReportExport;
use App\Exports\PayrollHonoraryReportExport;
use App\LawDiscount;
use App\PaymentPeriod;
use App\Payroll;
use App\PayrollDetail;
use App\PayrollStatus;
use App\RrhhAbsenceInability;
use App\RrhhIncomeDiscount;
use App\RrhhSalaryHistory;
use App\RrhhTypeWage;
use App\PayrollType;
use App\User;
use App\Utils\ModuleUtil;
use Illuminate\Http\Request;
use DB;
use DataTables;
use Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Notifications\PaymentSplisNotification;
use App\Utils\EmployeeUtil;

class PayrollController extends Controller
{
    protected $moduleUtil;
    protected $employeeUtil;

    /**
     * Constructor
     *
     * @param ModuleUtil $moduleUtil
     * @return void
     */
    public function __construct(ModuleUtil $moduleUtil, EmployeeUtil $employeeUtil)
    {
        $this->moduleUtil = $moduleUtil;
        $this->employeeUtil = $employeeUtil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('payroll.view')) {
            abort(403, "Unauthorized action.");
        }

        return view('payroll.index');
    }


    public function getPayrolls()
    {
        if (!auth()->user()->can('plantilla.view')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $data = DB::table('payrolls as payroll')
            ->join('payroll_types as payroll_type', 'payroll_type.id', '=', 'payroll.payroll_type_id')
            ->join('payment_periods as payment_period', 'payment_period.id', '=', 'payroll.payment_period_id')
            ->join('payroll_statuses as payroll_status', 'payroll_status.id', '=', 'payroll.payroll_status_id')
            ->select('payroll.id as id', 'payroll.*', 'payroll_status.name as status', 'payroll_type.name as type', 'payment_period.name as payment_period')
            ->where('payroll.business_id', $business_id)
            ->where('payroll.deleted_at', null)
            ->get();

        return DataTables::of($data)
            ->editColumn('period', '{{ @format_date($start_date) }} - {{ @format_date($end_date) }}')
            ->editColumn('month', function ($data) {
                $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                return $meses[$data->month - 1];
            })->editColumn('status', function ($data) {
                $html = '';
                if ($data->status == 'Aprobada') {
                    $html = '<span class="badge" style="background: #449D44">' . $data->status . '</span>';
                }
                if ($data->status == 'Calculada') {
                    $html = '<span class="badge" style="background: #00A6DC">' . $data->status . '</span>';
                }
                if ($data->status == 'Pagada') {
                    $html = '<span class="badge" style="background: #367FA9">' . $data->status . '</span>';
                }
                if ($data->status == 'Iniciada') {
                    $html = '<span class="badge">' . $data->status . '</span>';
                }
                return $html;
            })
            ->addColumn('statusPayroll', function ($data) {
                return $data->status;
            })
            ->rawColumns(['type', 'name', 'payment_period', 'period', 'status', 'statusPayroll'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('payroll.create')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $paymentPeriods = PaymentPeriod::where('business_id', $business_id)
            ->where('id', '<>', 1) //Semanal
            ->where('id', '<>', 2) //Catorcenal
            ->where('id', '<>', 3) //Quincenal
            ->where('id', '<>', 7) //Semestral
            ->where('id', '<>', 8) //Anual
            ->get();
        $payrollTypes = PayrollType::where('business_id', $business_id)->get();

        return view('payroll.create', compact('paymentPeriods', 'payrollTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('plantilla.create')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'payroll_type_id'    => 'required',
            'year'                => 'required',
            'month'               => 'required',
            'payment_period_id'   => 'required',
            'start_date'          => 'required',
            'end_date'            => 'required',
        ]);

        try {
            $input_details = $request->all();
            $business_id = request()->session()->get('user.business_id');
            $paymentPeriod = PaymentPeriod::where('id', $request->input('payment_period_id'))->where('business_id', $business_id)->first();
            $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
            $input_details['name'] = __('payroll.payroll') . ' ' . $paymentPeriod->name . ' - ' . $meses[$request->month - 1] . ' ' . $request->year;
            $input_details['business_id'] = $business_id;
            $input_details['start_date'] = $this->moduleUtil->uf_date($request->input('start_date'));
            $input_details['end_date'] = $this->moduleUtil->uf_date($request->input('end_date'));
            $status = PayrollStatus::where('name', 'Iniciada')->where('business_id', $input_details['business_id'])->first();
            $input_details['payroll_status_id'] = $status->id;

            DB::beginTransaction();

            $payroll = Payroll::create($input_details);
            if ($request->calculate == true) {
                $this->calculate($payroll);
            }

            DB::commit();

            $output = [
                'success' => 1,
                'msg' => __('rrhh.added_successfully')
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            $output = [
                'success' => 0,
                //'msg' => $e->getMessage()
                'msg' => __('rrhh.error')
            ];
        }

        return $output;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!auth()->user()->can('plantilla.view')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $payroll = Payroll::where('id', $id)->where('business_id', $business_id)->with('paymentPeriod')->firstOrFail();
        if ($payroll->payrollStatus->name == 'Iniciada') {
            $this->calculate($payroll);
            $payroll = Payroll::where('id', $id)->where('business_id', $business_id)->with('paymentPeriod')->firstOrFail();
        }

        return view('payroll.generate_payroll', compact('payroll'));
    }


    public function getPayrollDetail(Request $request, $id)
    {
        if (!auth()->user()->can('plantilla.view')) {
            abort(403, 'Unauthorized action.');
        }
        $business_id = request()->session()->get('user.business_id');
        $payroll = Payroll::where('id', $id)->where('business_id', $business_id)->firstOrFail();
        $data = PayrollDetail::where('payroll_id', $id)->with('payroll')->get();

        if ($payroll->payrollType->name == 'Planilla de sueldos') {
            return DataTables::of($data)
                ->editColumn('code', function ($data) {
                    return $data->employee->agent_code;
                })    
                ->editColumn('employee', function ($data) {
                    return $data->employee->first_name . ' ' . $data->employee->last_name;
                })->editColumn('montly_salary', function ($data) {
                    return $this->moduleUtil->num_f($data->montly_salary, $add_symbol = true, $precision = 2);
                })->editColumn('regular_salary', function ($data) {
                    return $this->moduleUtil->num_f($data->regular_salary, $add_symbol = true, $precision = 2);
                })->editColumn('commissions', function ($data) {
                    return $this->moduleUtil->num_f($data->commissions, $add_symbol = true, $precision = 2);
                })->editColumn('daytime_overtime', function ($data) {
                    return $this->moduleUtil->num_f($data->daytime_overtime, $add_symbol = true, $precision = 2);
                })->editColumn('night_overtime_hours', function ($data) {
                    return $this->moduleUtil->num_f($data->night_overtime_hours, $add_symbol = true, $precision = 2);
                })
                // ->editColumn('total_hours', function ($data) {
                //     return $this->moduleUtil->num_f($data->total_hours, $add_symbol = true, $precision = 2);
                // })
                ->editColumn('other_income', function ($data) {
                    return $this->moduleUtil->num_f($data->other_income, $add_symbol = true, $precision = 2);
                })->editColumn('total_income', function ($data) {
                    return '<b>'.$this->moduleUtil->num_f($data->total_income, $add_symbol = true, $precision = 2).'</b>';
                })->editColumn('isss', function ($data) {
                    return $this->moduleUtil->num_f($data->isss, $add_symbol = true, $precision = 2);
                })->editColumn('afp', function ($data) {
                    return $this->moduleUtil->num_f($data->afp, $add_symbol = true, $precision = 2);
                })->editColumn('rent', function ($data) {
                    return $this->moduleUtil->num_f($data->rent, $add_symbol = true, $precision = 2);
                })->editColumn('other_deductions', function ($data) {
                    return $this->moduleUtil->num_f($data->other_deductions, $add_symbol = true, $precision = 2);
                })->editColumn('total_deductions', function ($data) {
                    return '<b>'.$this->moduleUtil->num_f($data->total_deductions, $add_symbol = true, $precision = 2).'</b>';
                })->editColumn('total_to_pay', function ($data) {
                    return '<b>'.$this->moduleUtil->num_f($data->total_to_pay, $add_symbol = true, $precision = 2).'</b>';
                })
                ->rawColumns(['code', 'employee', 'montly_salary', 'days', 'regular_salary', 'commissions', 'daytime_overtime', 'night_overtime_hours','other_income', 'total_income', 'isss', 'afp', 'rent', 'other_deductions', 'total_deductions', 'total_to_pay'])
                ->make(true);
        }

        if ($payroll->payrollType->name == 'Planilla de honorarios') {
            return DataTables::of($data)
                ->editColumn('code', function ($data) {
                    return $data->employee->agent_code;
                })->editColumn('employee', function ($data) {
                    return $data->employee->first_name . ' ' . $data->employee->last_name;
                })->editColumn('regular_salary', function ($data) {
                    return $this->moduleUtil->num_f($data->regular_salary, $add_symbol = true, $precision = 2);
                })->editColumn('rent', function ($data) {
                    return $this->moduleUtil->num_f($data->rent, $add_symbol = true, $precision = 2);
                })->editColumn('total_to_pay', function ($data) {
                    return '<b>'.$this->moduleUtil->num_f($data->total_to_pay, $add_symbol = true, $precision = 2).'</b>';
                })
                ->rawColumns(['code', 'employee', 'montly_salary', 'rent', 'total_to_pay'])
                ->make(true);
        }
    }

    public function recalculate($id)
    {
        if (!auth()->user()->can('plantilla.recalculate')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = request()->session()->get('user.business_id');
            $payroll = Payroll::where('id', $id)->where('business_id', $business_id)->with('paymentPeriod', 'payrollType')->firstOrFail();

            if ($payroll->payrollStatus->name == 'Calculada') {
                DB::beginTransaction();

                PayrollDetail::where('payroll_id', $payroll->id)->delete();
                $this->calculate($payroll);

                DB::commit();

                $output = [
                    'success' => 1,
                    'msg' => __('payroll.recalculation_done_successfully')
                ];
            } else {
                \Log::info('Holi');
                $output = [
                    'success' => 0,
                    'msg' => __('payroll.failed_to_recalculate')
                ];
            }
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            $output = [
                'success' => 0,
                'msg' => __('rrhh.error')
            ];
        }

        return $output;
    }

    /** Payment Slips payroll */
    public function paymentSlips(Request $request, $id)
    {
        if (!auth()->user()->can('payroll.paymentSlips')) {
            abort(403, 'Unauthorized action.');
        }

        if ($request->ajax()) {
            try {
                DB::beginTransaction();
                $business_id = request()->session()->get('user.business_id');
                $payroll = Payroll::where('id', $id)->where('business_id', $business_id)->firstOrFail();
                $this->sendEmail($payroll);

                $output = [
                    'success' => 1,
                    'msg' => __('payroll.send_payment_slips')
                ];
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
                $output = [
                    'success' => 0,
                    'msg' => $e->getMessage()
                ];
            }
            return $output;
        }
    }

    /** Pay payroll */
    function sendEmail($payroll)
    {
        $business_id = request()->session()->get('user.business_id');
        $business = Business::findOrFail($business_id);
        foreach ($payroll->payrollDetails as $payrollDetail) {
            $employee = Employees::where('id', $payrollDetail->employee_id)->where('business_id', $business_id)->with('user')->firstOrFail();
            $employee->notify(new PaymentSplisNotification($payrollDetail->id, $employee->first_name, $employee->last_name));
        }  
    }


    public function generatePaymentSlips($id)
    {
        $business_id = request()->session()->get('user.business_id');
        $business = Business::find($business_id);
        $payrollDetail = PayrollDetail::where('id', $id)->firstOrFail();
        $start_date = $this->employeeUtil->getDate($payrollDetail->payroll->start_date, true);
        $end_date = $this->employeeUtil->getDate($payrollDetail->payroll->end_date, true);

        $pdf = \PDF::loadView('payroll.report_pdf',compact('payrollDetail', 'business', 'start_date', 'end_date'));

        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream(__('payroll.personnel_action') . '.pdf');  
    }


    /** Pay payroll */
    public function pay(Request $request, $id)
    {
        if (!auth()->user()->can('payroll.pay')) {
            abort(403, 'Unauthorized action.');
        }

        if ($request->ajax()) {
            try {
                DB::beginTransaction();
                $business_id = request()->session()->get('user.business_id');
                $payroll = Payroll::where('id', $id)->where('business_id', $business_id)->firstOrFail();
                $user_id = auth()->user()->id;
                $user = User::findOrFail($user_id);

                if (Hash::check($request->input('password'), $user->password)) {
                    $status = PayrollStatus::where('name', 'Pagada')->where('business_id', $business_id)->first();
                    $payroll->payroll_status_id = $status->id;
                    $payroll->pay_date = Carbon::now();
                    $payroll->update();

                    $rrhhIncomeDiscount = RrhhIncomeDiscount::where('')->get();

                    if ($request->input('sendEmail') == 1) {
                        $this->sendEmail($payroll);

                        $output = [
                            'success' => 1,
                            'msg' => __('payroll.send_pay_payroll')
                        ];
                    } else {
                        $output = [
                            'success' => 1,
                            'msg' => __('payroll.pay_payroll')
                        ];
                    }
                } else {
                    $output = [
                        'success' => 0,
                        'msg' => __('rrhh.wrong_password_authorize')
                    ];
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
                $output = [
                    'success' => 0,
                    'msg' => __('rrhh.error')
                ];
            }
            return $output;
        }
    }

    /** Approve payroll */
    public function approve(Request $request, $id)
    {
        if (!auth()->user()->can('payroll.approve')) {
            abort(403, 'Unauthorized action.');
        }

        if ($request->ajax()) {
            try {
                DB::beginTransaction();
                $business_id = request()->session()->get('user.business_id');
                $payroll = Payroll::where('id', $id)->where('business_id', $business_id)->firstOrFail();
                $user_id = auth()->user()->id;
                $user = User::findOrFail($user_id);

                if (Hash::check($request->input('password'), $user->password)) {
                    $status = PayrollStatus::where('name', 'Aprobada')->where('business_id', $business_id)->first();
                    $payroll->payroll_status_id = $status->id;
                    $payroll->approval_date = Carbon::now();
                    $payroll->update();

                    if ($request->input('sendEmail') == 1) {
                        $output = [
                            'success' => 1,
                            'msg' => __('payroll.send_approve_payroll')
                        ];
                    } else {
                        $output = [
                            'success' => 1,
                            'msg' => __('payroll.approve_payroll')
                        ];
                    }
                } else {
                    $output = [
                        'success' => 0,
                        'msg' => __('rrhh.wrong_password_authorize')
                    ];
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
                $output = [
                    'success' => 0,
                    'msg' => __('rrhh.error')
                ];
            }
            return $output;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //Calcular payroll
    public function calculate($payroll)
    {
        $business_id = request()->session()->get('user.business_id');
        if (mb_strtolower($payroll->paymentPeriod->name) == mb_strtolower('Primera quincena') || mb_strtolower($payroll->paymentPeriod->name) == mb_strtolower('Segunda quincena')) {
            $paymentPeriod = 'Quincenal';
        } else {
            $paymentPeriod = $payroll->paymentPeriod->name;
        }

        //Obtener empleados
        $employees = Employees::where('business_id', $business_id)
            ->where('date_admission', '<=', $payroll->end_date)
            ->where('status', 1)
            ->get();

        if (count($employees) > 0) {
            foreach ($employees as $employee) {
                $salaryHistory = RrhhSalaryHistory::where('employee_id', $employee->id)
                    ->where('current', 1)
                    ->orderBy('id', 'DESC')
                    ->first();

                if ($salaryHistory) {
                    $details['montly_salary'] = $salaryHistory->new_salary;
                    $typeWage = RrhhTypeWage::where('id', $employee->type_id)->first();

                    if ($payroll->payrollType->name == 'Planilla de sueldos') {
                        if ($typeWage->type == 'Ley de salario') { //----------------------LEY DE SALARIO----------------------
                            $discountDO = 0;
                            $discountNOH = 0;
                            $discountCom = 0; 
                            $discountOD = 0;
                            $discountOI = 0;
            
                            $incomeDO = 0;
                            $incomeNOH = 0;
                            $incomeCom = 0;
                            $incomeOD = 0;
                            $incomeOI = 0;

                            $diasIncapacidad = 0;
                            $start_date_payroll = Carbon::parse($payroll->start_date);
                            $end_date_payroll = Carbon::parse($payroll->end_date);

                            $incapacidades = RrhhAbsenceInability::where('type', 'Incapacidad')
                                ->where('start_date', '<=', $payroll->end_date)
                                ->where('employee_id', $employee->id)
                                ->get();

                            $incomeDiscounts = RrhhIncomeDiscount::join('rrhh_type_income_discounts as type', 'type.id', '=', 'rrhh_income_discounts.rrhh_type_income_discount_id')
                                ->select('rrhh_income_discounts.id as id', 'rrhh_income_discounts.*', 'type.payroll_column')
                                ->where('rrhh_income_discounts.employee_id', $employee->id)
                                ->where('rrhh_income_discounts.start_date', '<=', $payroll->end_date)
                                ->where('rrhh_income_discounts.deleted_at', null)
                                ->get();

                            $lawDiscounts = LawDiscount::join('institution_laws as institution_law', 'institution_law.id', '=', 'law_discounts.institution_law_id')
                                ->join('payment_periods as payment_period', 'payment_period.id', '=', 'law_discounts.payment_period_id')
                                ->select('law_discounts.id as id', 'law_discounts.*', 'payment_period.name as payment_period', 'institution_law.name as institution_law')
                                ->where('payment_period.name', $paymentPeriod)
                                ->where('law_discounts.business_id', $business_id)
                                ->where('law_discounts.deleted_at', null)
                                ->get();

                            $lawDiscountsRenta = LawDiscount::join('institution_laws as institution_law', 'institution_law.id', '=', 'law_discounts.institution_law_id')
                                ->join('payment_periods as payment_period', 'payment_period.id', '=', 'law_discounts.payment_period_id')
                                ->select('law_discounts.id as id', 'law_discounts.*', 'institution_law.name as institution_law', 'payment_period.name as payment_period')
                                ->where('institution_law.name', 'Renta')
                                ->where('payment_period.name', $paymentPeriod)
                                ->where('law_discounts.business_id', $business_id)
                                ->where('law_discounts.deleted_at', null)
                                ->get();


                            //Calcular los días de incapacidad
                            foreach ($incapacidades as $incapacidad) {
                                $start_date_incapacidad = Carbon::parse($incapacidad->start_date);
                                $end_date_incapacidad = Carbon::parse($incapacidad->end_date);

                                if ($incapacidad->start_date >= $payroll->start_date && $incapacidad->end_date <= $payroll->end_date) {
                                    $diasIncapacidad += $end_date_incapacidad->diffInDays($start_date_incapacidad);
                                }

                                if ($incapacidad->start_date >= $payroll->start_date && $incapacidad->end_date > $payroll->end_date) {
                                    $diasIncapacidad += $end_date_payroll->diffInDays($start_date_incapacidad);
                                }

                                if ($incapacidad->start_date < $payroll->start_date && $incapacidad->end_date <= $payroll->end_date) {
                                    $diasIncapacidad += $end_date_incapacidad->diffInDays($start_date_payroll);
                                }

                                if ($incapacidad->start_date < $payroll->start_date && $incapacidad->end_date > $payroll->end_date) {
                                    $diasIncapacidad += $end_date_payroll->diffInDays($start_date_payroll);
                                }
                            }

                            //Obteniendo el calculo total de cada ingreso o descuento
                            foreach ($incomeDiscounts as $incomeDiscount) {
                                $payrollColumnDO = 'Número de horas extras diurnas';
                                $payrollColumnNOH = 'Número de horas extras nocturnas';
                                $payrollColumnCom = 'Comisiones';
                                $payrollColumnOD = 'Otras deducciones';
                                $payrollColumnOI = 'Otros ingresos';
                                if ($incomeDiscount->start_date >= $payroll->start_date && $incomeDiscount->end_date <= $payroll->end_date) {

                                    ($incomeDiscount->rrhhTypeIncomeDiscount->type == 1) ? $incomeDO += $this->incomeDiscount($incomeDiscount, $payrollColumnDO) : $discountDO += $this->incomeDiscount($incomeDiscount, $payrollColumnDO);
                                    ($incomeDiscount->rrhhTypeIncomeDiscount->type == 1) ? $incomeNOH += $this->incomeDiscount($incomeDiscount, $payrollColumnNOH) : $discountNOH += $this->incomeDiscount($incomeDiscount, $payrollColumnNOH);
                                    ($incomeDiscount->rrhhTypeIncomeDiscount->type == 1) ? $incomeCom += $this->incomeDiscount($incomeDiscount, $payrollColumnCom) : $discountCom += $this->incomeDiscount($incomeDiscount, $payrollColumnCom);
                                    ($incomeDiscount->rrhhTypeIncomeDiscount->type == 1) ? $incomeOD += $this->incomeDiscount($incomeDiscount, $payrollColumnOD) : $discountOD += $this->incomeDiscount($incomeDiscount, $payrollColumnOD);
                                    ($incomeDiscount->rrhhTypeIncomeDiscount->type == 1) ? $incomeOI += $this->incomeDiscount($incomeDiscount, $payrollColumnOI) : $discountOI += $this->incomeDiscount($incomeDiscount, $payrollColumnOI);

                                }

                                if ($incomeDiscount->start_date >= $payroll->start_date && $incomeDiscount->end_date > $payroll->end_date) {

                                    ($incomeDiscount->rrhhTypeIncomeDiscount->type == 1) ? $incomeDO += $this->incomeDiscount($incomeDiscount, $payrollColumnDO) : $discountDO += $this->incomeDiscount($incomeDiscount, $payrollColumnDO);
                                    ($incomeDiscount->rrhhTypeIncomeDiscount->type == 1) ? $incomeNOH += $this->incomeDiscount($incomeDiscount, $payrollColumnNOH) : $discountNOH += $this->incomeDiscount($incomeDiscount, $payrollColumnNOH);
                                    ($incomeDiscount->rrhhTypeIncomeDiscount->type == 1) ? $incomeCom += $this->incomeDiscount($incomeDiscount, $payrollColumnCom) : $discountCom += $this->incomeDiscount($incomeDiscount, $payrollColumnCom);
                                    ($incomeDiscount->rrhhTypeIncomeDiscount->type == 1) ? $incomeOD += $this->incomeDiscount($incomeDiscount, $payrollColumnOD) : $discountOD += $this->incomeDiscount($incomeDiscount, $payrollColumnOD);
                                    ($incomeDiscount->rrhhTypeIncomeDiscount->type == 1) ? $incomeOI += $this->incomeDiscount($incomeDiscount, $payrollColumnOI) : $discountOI += $this->incomeDiscount($incomeDiscount, $payrollColumnOI);

                                }

                                if ($incomeDiscount->start_date < $payroll->start_date && $incomeDiscount->end_date <= $payroll->end_date) {

                                    ($incomeDiscount->rrhhTypeIncomeDiscount->type == 1) ? $incomeDO += $this->incomeDiscount($incomeDiscount, $payrollColumnDO) : $discountDO += $this->incomeDiscount($incomeDiscount, $payrollColumnDO);
                                    ($incomeDiscount->rrhhTypeIncomeDiscount->type == 1) ? $incomeNOH += $this->incomeDiscount($incomeDiscount, $payrollColumnNOH) : $discountNOH += $this->incomeDiscount($incomeDiscount, $payrollColumnNOH);
                                    ($incomeDiscount->rrhhTypeIncomeDiscount->type == 1) ? $incomeCom += $this->incomeDiscount($incomeDiscount, $payrollColumnCom) : $discountCom += $this->incomeDiscount($incomeDiscount, $payrollColumnCom);
                                    ($incomeDiscount->rrhhTypeIncomeDiscount->type == 1) ? $incomeOD += $this->incomeDiscount($incomeDiscount, $payrollColumnOD) : $discountOD += $this->incomeDiscount($incomeDiscount, $payrollColumnOD);
                                    ($incomeDiscount->rrhhTypeIncomeDiscount->type == 1) ? $incomeOI += $this->incomeDiscount($incomeDiscount, $payrollColumnOI) : $discountOI += $this->incomeDiscount($incomeDiscount, $payrollColumnOI);

                                }

                                if ($incomeDiscount->start_date < $payroll->start_date && $incomeDiscount->end_date > $payroll->end_date) {

                                    ($incomeDiscount->rrhhTypeIncomeDiscount->type == 1) ? $incomeDO += $this->incomeDiscount($incomeDiscount, $payrollColumnDO) : $discountDO += $this->incomeDiscount($incomeDiscount, $payrollColumnDO);
                                    ($incomeDiscount->rrhhTypeIncomeDiscount->type == 1) ? $incomeNOH += $this->incomeDiscount($incomeDiscount, $payrollColumnNOH) : $discountNOH += $this->incomeDiscount($incomeDiscount, $payrollColumnNOH);
                                    ($incomeDiscount->rrhhTypeIncomeDiscount->type == 1) ? $incomeCom += $this->incomeDiscount($incomeDiscount, $payrollColumnCom) : $discountCom += $this->incomeDiscount($incomeDiscount, $payrollColumnCom);
                                    ($incomeDiscount->rrhhTypeIncomeDiscount->type == 1) ? $incomeOD += $this->incomeDiscount($incomeDiscount, $payrollColumnOD) : $discountOD += $this->incomeDiscount($incomeDiscount, $payrollColumnOD);
                                    ($incomeDiscount->rrhhTypeIncomeDiscount->type == 1) ? $incomeOI += $this->incomeDiscount($incomeDiscount, $payrollColumnOI) : $discountOI += $this->incomeDiscount($incomeDiscount, $payrollColumnOI);

                                }
                            }

                            //Calcular los días trabajados
                            if ($employee->date_admission >= $payroll->start_date) {
                                $daysPayroll = $end_date_payroll->diffInDays($employee->date_admission);
                                $details['days'] = $daysPayroll - $diasIncapacidad;
                            } else {
                                $details['days'] = abs($payroll->paymentPeriod->days - $diasIncapacidad);
                            }

                            $details['hours'] = 8;
                            $details['commissions'] = $incomeCom - $discountCom;
                            $details['number_daytime_overtime'] = 0;
                            $details['daytime_overtime'] = $incomeDO - $discountDO;
                            $details['number_night_overtime_hours'] = 0;
                            $details['night_overtime_hours'] = $incomeNOH - $discountNOH;
                            $details['total_hours'] = $details['daytime_overtime'] + $details['night_overtime_hours'];
                            $details['other_income'] = $incomeOI - $discountOI;
                            $details['regular_salary'] = $details['montly_salary'] / 30 * $details['days'];
                            $details['total_income'] = $details['regular_salary'] + $details['commissions'] + $details['total_hours'] + $details['other_income'];

                            //Calcular ISSS y AFP
                            foreach ($lawDiscounts as $lawDiscount) {
                                //---------------------------------ISSS---------------------------------
                                if (mb_strtolower($lawDiscount->institution_law) == mb_strtolower('ISSS')) {
                                    if (mb_strtolower($lawDiscount->payment_period) == mb_strtolower($paymentPeriod)) {
                                        if ($details['total_income'] >= $lawDiscount->until) {
                                            $details['isss'] = $lawDiscount->until * $lawDiscount->employee_percentage / 100;
                                        } else {
                                            $details['isss'] = $details['total_income'] * $lawDiscount->employee_percentage / 100;
                                        }
                                    }
                                }

                                //---------------------------------AFP---------------------------------
                                if ($lawDiscount->institution_law == 'AFP Confia' || $lawDiscount->institution_law == 'AFP Crecer') {
                                    if (mb_strtolower($lawDiscount->payment_period) == mb_strtolower($paymentPeriod)) {
                                        $details['afp'] = $details['total_income'] * $lawDiscount->employee_percentage / 100;
                                    }
                                }
                            }

                            //Calcular Renta        
                            for ($i = 0; $i < count($lawDiscountsRenta); $i++) {
                                if (($details['total_income'] - $details['isss'] - $details['afp']) <= $lawDiscountsRenta[0]->until) {
                                    $details['rent'] = 0;
                                } else {
                                    if (($details['total_income'] - $details['isss'] - $details['afp']) <= $lawDiscountsRenta[1]->until) {
                                        $details['rent'] = round(((($details['total_income'] - $details['isss'] - $details['afp']) - $lawDiscountsRenta[1]->base) * ($lawDiscountsRenta[1]->employee_percentage / 100)) + $lawDiscountsRenta[1]->fixed_fee, 2);
                                    } else {
                                        if (($details['total_income'] - $details['isss'] - $details['afp']) <= $lawDiscountsRenta[2]->until) {
                                            $details['rent'] = round(((($details['total_income'] - $details['isss'] - $details['afp']) - $lawDiscountsRenta[2]->base) * ($lawDiscountsRenta[2]->employee_percentage / 100)) + $lawDiscountsRenta[2]->fixed_fee, 2);
                                        } else {
                                            if (($details['total_income'] - $details['isss'] - $details['afp']) <= $lawDiscountsRenta[3]->until) {
                                                $details['rent'] = round(((($details['total_income'] - $details['isss'] - $details['afp']) - $lawDiscountsRenta[3]->base) * ($lawDiscountsRenta[3]->employee_percentage / 100)) + $lawDiscountsRenta[3]->fixed_fee, 2);
                                            }
                                        }
                                    }
                                }
                            }

                            $details['other_deductions'] = $discountOD - $incomeOD;
                            $details['total_deductions'] = $details['isss'] + $details['afp'] + $details['rent'] + $details['other_deductions'];
                            $details['total_to_pay'] = bcdiv(($details['total_income'] - $details['total_deductions']), 1, 2);
                            $details['employee_id']  = $employee->id;
                            $details['payroll_id']  = $payroll->id;

                            //Create register
                            PayrollDetail::create($details);
                        }
                    }

                    if ($payroll->payrollType->name == 'Planilla de honorarios') {
                        if ($typeWage->type == 'Honorario') { //----------------------HONORARIO----------------------
                            if ($employee->date_admission >= $payroll->start_date) {
                                $end_date_payroll = Carbon::parse($payroll->end_date);
                                $daysPayroll = $end_date_payroll->diffInDays($employee->date_admission);
                                $details['days'] = $daysPayroll;
                            } else {
                                $details['days'] = $payroll->paymentPeriod->days;
                            }
                            $details['regular_salary'] = $details['montly_salary'] / 30 * $details['days'];
                            $details['rent'] = $details['regular_salary'] * 0.1;
                            $details['total_to_pay'] = bcdiv($details['regular_salary'] - $details['rent'], 1, 2);
                            $details['employee_id']  = $employee->id;
                            $details['payroll_id']  = $payroll->id;

                            //Create register
                            PayrollDetail::create($details);
                        }
                    }



                    $status = PayrollStatus::where('name', 'Calculada')->where('business_id', $business_id)->first();
                    $payroll->payroll_status_id = $status->id;
                    $payroll->update();
                } else {
                    //Mensaje que debe completar la info de los empleados
                }
            }
        } else {
            //Mensaje que no hay empleados
        }
    }


    public function exportPayrollSalary($id)
    {
        $business_id = request()->session()->get('user.business_id');
        $business = Business::where('id', $business_id)->first();
        $payroll = Payroll::where('id', $id)->where('business_id', $business_id)->with('payrollType')->firstOrFail();
        $payrollDetails = PayrollDetail::where('payroll_id', $id)->with('payroll')->get();

        if ($payroll->payrollType->name == 'Planilla de sueldos') {
            return Excel::download(
                new PayrollSalaryReportExport($payroll, $payrollDetails, $business, $this->moduleUtil),
                'Planilla de sueldos - ' . $payroll->name . '.xlsx'
            );
        }
        if ($payroll->payrollType->name == 'Planilla de honorarios') {
            return Excel::download(
                new PayrollHonoraryReportExport($payroll, $payrollDetails, $business, $this->moduleUtil),
                'Planilla de honorarios - ' . $payroll->name . '.xlsx'
            );
        }
    }

    public function incomeDiscount($incomeDiscount, $payroll_column)
    {
        $incomeOrDiscount = 0;
        if ($incomeDiscount->payroll_column == $payroll_column) {
            $incomeOrDiscount = $incomeDiscount->quota_value;
        }

        return $incomeOrDiscount;
    }
}
