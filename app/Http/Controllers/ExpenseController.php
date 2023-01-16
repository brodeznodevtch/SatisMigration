<?php

namespace App\Http\Controllers;

use App\BankAccount;
use App\BankTransaction;
use Illuminate\Http\Request;

use App\Transaction;
use App\ExpenseCategory;
use App\BusinessLocation;
use App\Contact;
use App\DocumentType;
use App\PaymentTerm;
use App\TransactionPayment;
use App\TypeBankTransaction;
use App\User;
use App\Utils\BusinessUtil;
use Validator;

use Yajra\DataTables\Facades\DataTables;

use App\Utils\TransactionUtil;
use App\Utils\ModuleUtil;
use App\Utils\TaxUtil;
use DB;

class ExpenseController extends Controller
{
    /**
     * Constructor
     *
     * @param TransactionUtil $transactionUtil
     * @return void
     */
    public function __construct(TransactionUtil $transactionUtil, ModuleUtil $moduleUtil, TaxUtil $taxUtil, BusinessUtil $businessUtil)
    {
        $this->transactionUtil = $transactionUtil;
        $this->moduleUtil = $moduleUtil;
        $this->taxUtil = $taxUtil;
        $this->businessUtil = $businessUtil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('expense.access')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');

            $expenses = Transaction::leftJoin('expense_categories AS ec', 'transactions.expense_category_id', '=', 'ec.id')
                ->join('business_locations AS bl', 'transactions.location_id', 'bl.id')
                ->leftJoin('users AS U', 'transactions.expense_for', '=', 'U.id')
                ->leftJoin('transaction_payments AS TP', 'transactions.id', 'TP.transaction_id')
                ->join('document_types', 'document_types.id', '=', 'transactions.document_types_id')
                ->leftJoin('contacts', 'contacts.id', 'transactions.contact_id')
                ->where('transactions.business_id', $business_id)
                ->where('transactions.type', 'expense')
                ->select(
                    'transactions.id',
                    'bl.name as location_name',
                    'ec.name as category',
                    'document_types.short_name',
                    'transactions.document',
                    'transaction_date',
                    'ref_no',
                    'payment_status',
                    'final_total',
                    'contacts.name as supplier'
                )
                ->groupBy('transactions.id');

            //Add condition for expense for,used in sales representative expense report
            if (request()->has('expense_for')) {
                $expense_for = request()->get('expense_for');
                if (!empty($expense_for)) {
                    $expenses->where('transactions.expense_for', $expense_for);
                }
            }

            //Add condition for location,used in sales representative expense report
            if (request()->has('location_id')) {
                $location_id = request()->get('location_id');
                if (!empty($location_id)) {
                    $expenses->where('transactions.location_id', $location_id);
                }
            }

            //Add condition for start and end date filter, uses in sales representative expense report
            if (!empty(request()->start_date) && !empty(request()->end_date)) {
                $start = request()->start_date;
                $end =  request()->end_date;
                $expenses->whereDate('transaction_date', '>=', $start)
                    ->whereDate('transaction_date', '<=', $end);
            }

            //Add condition for expense category, used in list of expense,
            if (request()->has('expense_category_id')) {
                $expense_category_id = request()->get('expense_category_id');
                if (!empty($expense_category_id)) {
                    $expenses->where('transactions.expense_category_id', $expense_category_id);
                }
            }

            $permitted_locations = auth()->user()->permitted_locations();
            if ($permitted_locations != 'all') {
                $expenses->whereIn('transactions.location_id', $permitted_locations);
            }

            return Datatables::of($expenses)
                ->addColumn(
                    'action',
                    '<div class="btn-group">
                        <button type="button" class="btn btn-info dropdown-toggle btn-xs" 
                            data-toggle="dropdown" aria-expanded="false"> @lang("messages.actions")<span class="caret"></span><span class="sr-only">Toggle Dropdown
                                </span>
                        </button>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                    <li><a style="cursor: pointer" data-href="{{action(\'ExpenseController@edit\', [$id])}}" class="edit_expense_button"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")</a></li>
                    @if($document)
                        <li><a href="{{ url(\'uploads/documents/\' . $document)}}" 
                        download=""><i class="fa fa-download" aria-hidden="true"></i> @lang("purchase.download_document")</a></li>
                    @endif
                    <li>
                        <a style="cursor: pointer" data-href="{{action(\'ExpenseController@destroy\', [$id])}}" class="delete_expense"><i class="glyphicon glyphicon-trash"></i> @lang("messages.delete")</a></li>
                    <li class="divider"></li> 
                    @if($payment_status != "paid")
                        <li><a href="{{action("TransactionPaymentController@addPayment", [$id])}}" class="add_payment_modal"><i class="fa fa-money" aria-hidden="true"></i> @lang("purchase.add_payment")</a></li>
                    @endif
                    <li><a href="{{action("TransactionPaymentController@show", [$id])}}" class="view_payment_modal"><i class="fa fa-money" aria-hidden="true" ></i> @lang("purchase.view_payments")</a></li>
                    </ul></div>'
                )
                ->removeColumn('id')
                ->editColumn(
                    'final_total',
                    '<span class="display_currency final-total" data-currency_symbol="true" data-orig-value="{{$final_total}}">{{$final_total}}</span>'
                )
                ->editColumn('transaction_date', '{{@format_date($transaction_date)}}')
                // ->editColumn('dci', '{{$dci->document_type[\' id\'}}')   
                ->editColumn(
                    'payment_status',
                    '<a href="{{ action("TransactionPaymentController@show", [$id])}}" class="view_payment_modal payment-status" data-orig-value="{{$payment_status}}" data-status-name="{{__(\'lang_v1.\' . $payment_status)}}"><span class="label @payment_status($payment_status)">{{__(\'lang_v1.\' . $payment_status)}}
                        </span></a>'
                )
                ->rawColumns(['final_total', 'payment_status', 'action'])
                ->toJson();
        }

        $business_id = request()->session()->get('user.business_id');

        $categories = ExpenseCategory::where('business_id', $business_id)
            ->pluck('name', 'id');

        $users = User::forDropdown($business_id, false, true, true);

        $business_locations = BusinessLocation::forDropdown($business_id, true);

        // Expense settings
        $business_details = $this->businessUtil->getDetails($business_id);

        $expense_settings = empty($business_details->expense_settings) ? $this->businessUtil->defaultExpenseSettings() : json_decode($business_details->expense_settings, true);
        $hide_location_column = isset($expense_settings['hide_location_column']) ? $expense_settings['hide_location_column'] : 0;

        return view('expense.index')
            ->with(compact('categories', 'business_locations', 'users', 'hide_location_column'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('expense.create')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = auth()->user()->business_id;

        $business_locations = BusinessLocation::forDropdown($business_id, false);

        $document = DocumentType::where('is_document_purchase', 1)
            ->pluck('document_name', 'id');
        $payment_term = PaymentTerm::where('business_id', $business_id)->pluck('name', 'id');
        $tax_groups = $this->taxUtil->getTaxGroups($business_id, 'products', true);
        
        $payment_condition = [
            'cash' => __('order.cash'),
            'credit' => __('order.credit')
        ];
        $payment_terms = PaymentTerm::forDropdown($business_id);

        return view('expense.create',
            compact('document',
                'business_locations',
                'payment_term',
                'tax_groups',
                'payment_condition',
                'payment_terms'));
    }

    public function getSuppliers()
    {
        if (request()->ajax()) {
            $term = request()->q;
            if (empty($term)) {
                return json_encode([]);
            }

            $business_id = request()->session()->get('user.business_id');
            $user_id = request()->session()->get('user.id');

            $query = Contact::where('business_id', $business_id);

            $suppliers = $query->where(function ($query) use ($term) {
                    $query->where('name', 'like', '%' . $term . '%')
                        ->orWhere('supplier_business_name', 'like', '%' . $term . '%')
                        ->orWhere('contacts.contact_id', 'like', '%' . $term . '%');
                })
                ->select(
                    'contacts.id',
                    'name as text',
                    'supplier_business_name as business_name',
                    'contacts.contact_id',
                    'contacts.is_exempt',
                    'contacts.tax_group_id'
                )
                ->onlySuppliers()
                ->get();

            foreach ($suppliers as $supplier) {
                $supplier->tax_percent = $this->taxUtil->getTaxPercent($supplier->tax_group_id);
                $supplier->tax_min_amount = $this->taxUtil->getTaxMinAmount($supplier->tax_group_id);
                $supplier->tax_max_amount = $this->taxUtil->getTaxMaxAmount($supplier->tax_group_id);
            }

            return json_encode($suppliers);
        }
    }

    public function getAccount()
    {
        // if (request()->ajax()) {
        $term = request()->q;
        if (empty($term)) {
            return json_encode([]);
        }

        $business_id = request()->session()->get('user.business_id');
        $user_id = request()->session()->get('user.id');

        $query = ExpenseCategory::where('business_id', $business_id)
            ->join('catalogues', 'catalogues.id', '=', 'expense_categories.account_id');

        $account = $query->where(function ($query) use ($term) {
            $query->where('expense_categories.name', 'like', '%' . $term . '%');
        })
            ->select(
                [
                    'expense_categories.id',
                    'expense_categories.name as text',
                    'catalogues.name as business_name', 
                    'expense_categories.id as ide',
                    'catalogues.code as coc'
                ]
            )
            ->get();
        return json_encode($account);
        // }
    }

    public function store(Request $request)
    {
        if (!auth()->user()->can('expense.create')) {
            abort(403, 'Unauthorized action.');
        }
        // return $request;

        if(!auth()->user()->can('is_close_book') &&
            $this->transactionUtil->isClosed($request->input('transaction_date')) > 0){
            
            return $output = [
                'success' => 0,
                'msg' => __('purchase.month_closed')
            ];
        }

        //Validate document size
        $request->validate(
            [
                'document_types_id' => 'required',
                'document' => 'file|max:' . (config('constants.document_size_limit') / 1000),
                'ref_no' => 'required|alpha_num',
                'document' => 'file|max:' . (config('constants.document_size_limit') / 1000)
            ],
            [
                'document_types_id.required' => trans('expense.expense_document_types_required'),
                'ref_no.required' => trans('expense.expense_ref_no_required'),
                'ref_no.alpha_num' => trans('expense.expense_alpha_num')
            ]
        );


        try {

            $business_id = auth()->user()->business_id;
            $user_id = auth()->user()->id;

            // Check if subscribed or not
            if (!$this->moduleUtil->isSubscribed($business_id)) {
                return $this->moduleUtil->expiredResponse(action('ExpenseController@index'));
            }

            $transaction_data = $request->only([
                'transaction_date',
                'final_total',
                'additional_notes',
                'contact_id',
                'document_types_id',
                'ref_no',
                'total_before_tax',
                'payment_condition',
                'payment_term_id',
                'expense_category_id',
                'document_date',
                'serie',
                'exempt_amount'
            ]);


            $transaction_data['business_id'] = $business_id;
            $transaction_data['location_id'] = $request->get('location_id');
            $transaction_data['created_by'] = $user_id;
            $transaction_data['status'] = 'final';
            $transaction_data['type'] = 'expense';
            $transaction_data['tax_id'] = $request->input('tax_group_id') === 'nulled' ? null : $request->tax_group_id ;
            $transaction_data['payment_status'] = 'due';
            $transaction_data['transaction_date'] = $this->transactionUtil->uf_date($transaction_data['transaction_date']);
            $transaction_data['total_before_tax'] = $this->transactionUtil->num_uf(
                $transaction_data['total_before_tax']
            );
            $transaction_data['tax_group_amount'] = $this->transactionUtil->num_uf(
                $request->input('tax_amount')
            );
            $transaction_data['tax_amount'] = $this->transactionUtil->num_uf(
                $request->input('perception_amount')
            );
            $transaction_data['exempt_amount'] = $this->transactionUtil->num_uf(
                $transaction_data['exempt_amount']
            );
            $transaction_data['final_total'] = $this->transactionUtil->num_uf(
                $transaction_data['final_total']
            );

            //Update reference document
            $ref_count = $this->transactionUtil->setAndGetReferenceCount('expense');
            //Generate reference number
            if (empty($transaction_data['ref_no'])) {
                $transaction_data['ref_no'] = $this->transactionUtil->generateReferenceNumber('expense', $ref_count);
            }

            // upload document
            $document_name = $this->transactionUtil->uploadFile($request, 'document', 'documents');
            if (!empty($document_name)) {
                $transaction_data['document'] = $document_name;
            }

            $transaction_data['document_date'] = $this->transactionUtil->uf_date($transaction_data['document_date']);

            $transaction = Transaction::create($transaction_data);

            $output = [
                'success' => 1,
                'msg' => __('expense.expense_add_success')
            ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

            $output = [
                'success' => 0,
                'msg' => __('messages.something_went_wrong')
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
        //
    }


    public function edit($id)
    {
        if (!auth()->user()->can('expense.update')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = auth()->user()->business_id;
        $business_locations = BusinessLocation::forDropdown($business_id, false);
        $expense = Transaction::where('business_id', $business_id)->where('id', $id)->with('contact')->first();
        $document = DocumentType::select('document_name')->select('id', 'document_name')->pluck('document_name', 'id');
        $payment_term = PaymentTerm::where('business_id', $business_id)->pluck('name', 'id');
        $tax_groups = $this->taxUtil->getTaxGroups($business_id, 'products', true);
        $tax_percent = $this->taxUtil->getTaxPercent($expense->contact->tax_group_id);
        $tax_min_amount = $this->taxUtil->getTaxMinAmount($expense->contact->tax_group_id);
        $tax_max_amount = $this->taxUtil->getTaxMaxAmount($expense->contact->tax_group_id);
        
        return view('expense.edit', compact(
            'expense',
            'document',
            'business_locations',
            'payment_term',
            'tax_groups',
            'tax_percent',
            'tax_min_amount',
            'tax_max_amount'
        ));
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
        // dd($request->contact_id);
        if (!auth()->user()->can('expense.update')) {
            abort(403, 'Unauthorized action.');
        }

        if(!auth()->user()->can('is_close_book') &&
            $this->transactionUtil->isClosed($request->input('transaction_date')) > 0){
            return $output = [
                'success' => 0,
                'msg' => __('purchase.month_closed')
            ];
        }

        $request->validate(
            [
                'document_types_id' => 'required',
                'document' => 'file|max:' . (config('constants.document_size_limit') / 1000),
                'ref_no' => 'required|alpha_num',
                'document' => 'file|max:' . (config('constants.document_size_limit') / 1000)
            ],
            [
                'document_types_id.required' => trans('expense.expense_document_types_required'),
                'ref_no.required' => trans('expense.expense_ref_no_required'),
                'ref_no.alpha_num' => trans('expense.expense_alpha_num')
            ]
        );

        try {
            $business_id = auth()->user()->business_id;
            // Check if subscribed or not
            if (!$this->moduleUtil->isSubscribed($business_id)) {
                return $this->moduleUtil->expiredResponse(action('ExpenseController@index'));
            }

            $transaction_data = $request->only([
                'type',
                'transaction_date',
                'final_total',
                'location_id',
                'additional_notes',
                'document_types_id',
                'contact_id',
                'ref_no',
                'total_before_tax',
                'payment_condition',
                'payment_term_id',
                'expense_category_id',
                'document_date',
                'serie',
                'exempt_amount'
            ]);
            // dd($transaction_data);

            $transaction_data['transaction_date'] = $this->transactionUtil->uf_date($transaction_data['transaction_date']);
            $transaction_data['total_before_tax'] = $this->transactionUtil->num_uf(
                $transaction_data['total_before_tax']
            );
            $transaction_data['tax_group_amount'] = $this->transactionUtil->num_uf(
                $request->input('tax_amount')
            );
            $transaction_data['tax_amount'] = $this->transactionUtil->num_uf(
                $request->input('perception_amount')
            );
            $transaction_data['exempt_amount'] = $this->transactionUtil->num_uf(
                $transaction_data['exempt_amount']
            );
            $transaction_data['final_total'] = $this->transactionUtil->num_uf(
                $transaction_data['final_total']
            );
            $transaction_data['tax_id'] = $request->input('tax_group_id') === 'nulled' ? null : $request->tax_group_id ;
            //upload document
            $document_name = $this->transactionUtil->uploadFile($request, 'document', 'documents');
            if (!empty($document_name)) {
                $transaction_data['document'] = $document_name;
            }

            $transaction_data['document_date'] = $this->transactionUtil->uf_date($transaction_data['document_date']);

            Transaction::where('business_id', $business_id)
                ->where('id', $id)
                ->update($transaction_data);

            $output = [
                'success' => 1,
                'msg' => __('expense.expense_update_success')
            ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

            $output = [
                'success' => 0,
                'msg' => __('messages.something_went_wrong')
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
    public function destroy($id)
    {
        if (!auth()->user()->can('expense.delete')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $business_id = request()->session()->get('user.business_id');

                $expense = Transaction::where('business_id', $business_id)
                    ->where('type', 'expense')
                    ->where('id', $id)
                    ->first();
                $expense->delete();

                $output = [
                    'success' => true,
                    'msg' => __("expense.expense_delete_success")
                ];
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

                $output = [
                    'success' => false,
                    'msg' => __("messages.something_went_wrong")
                ];
            }

            return $output;
        }
    }

    /**
     * Show all expenses from checks.
     * 
     * @param  int  $bank_transaction_id
     * @return \Illuminate\Http\Response
     */
    public function getAddExpenses($bank_transaction_id = null) {
        if (! auth()->user()->can('expense.access')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get("user.business_id");


        return view("expense.partials.expenses")
            ->with(compact("bank_transaction_id"));
    }

    /**
     * POST Add expenses from checks.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function postAddExpenses(Request $request){
        if (! auth()->user()->can('expense.access')) {
            abort(403, 'Unauthorized action.');
        }

        $bank_transaction_id = $request->input("bank_transaction_id");
        $transaction = BankTransaction::find($bank_transaction_id);

        $check_amount = $transaction->amount;

        $expenses = $request->input("expenses");

        $bank_account = BankAccount::find($transaction->bank_account_id);

        // Validation to allow the check amount not to match expenses total
        if ($this->transactionUtil->validateMatchCheckAndExpense($check_amount, $expenses, 'update')) {
            return [
                'success' => false,
                'msg' => __('accounting.match_check_n_expense_error')
            ];
        }

        $type_bank_transaction = TypeBankTransaction::find($transaction->type_bank_transaction_id);

        $payment_method = 'bank_transfer';

        if (in_array(strtolower($type_bank_transaction->name), ['cheques', 'cheque', 'checks', 'check'])) {
            $payment_method = 'check';
        }

        foreach ($expenses as $e) {
            // Update expense
            $expense = Transaction::where("id", $e)
                ->first();

            $expense->bank_transaction_id = $bank_transaction_id;
            $expense->payment_status = "paid";

            // Save payment
            $payment = new TransactionPayment();
            $payment->amount = $expense->final_total;
            $payment->method = $payment_method;
            $payment->paid_on = $transaction->date;

            if ($payment_method == 'check') {
                $payment->check_number = $transaction->check_number;
                $payment->check_account = ! empty($bank_account) ? $bank_account->number : '';
                $payment->check_bank = ! empty($bank_account) ? $bank_account->bank_id : null;
                $payment->check_account_owner = null;

                $prefix_type = 'expense_payment';
                $ref_count = $this->transactionUtil->setAndGetReferenceCount($prefix_type);

                //Generate reference number
                $payment->transfer_ref_no = $transaction->reference;

            } else {
                $payment->transfer_ref_no = $transaction->reference;
                $payment->transfer_issuing_bank = null;
                $payment->transfer_receiving_bank = ! empty($bank_account) ? $bank_account->bank_id : null;
            }

            $payment->transaction_id = $expense->id;
            $payment->created_by = $request->session()->get('user.id');
            $payment->business_id = $request->session()->get("user.business_id");

            $payment->save();

            $expense->save();
        }

        return [
            'success' => true,
            'msg' => __('expense.transaction_paid_success')
        ];
    }

    /**
     * Get purchases and expenses for select2
     * @param string
     */
    public function getPurchasesExpenses(){
        if(request()->ajax()){
            $business_id = request()->user()->business_id;
            $q = request()->input('q', '');

            $query = Transaction::where("transactions.business_id", $business_id)
                ->join("contacts as c", "transactions.contact_id", "c.id")
                ->join("document_types as dt", "transactions.document_types_id", "dt.id")
                ->whereIn("transactions.type", ["expense", "purchase"])
                ->where("transactions.payment_status", "due");

            $transctions = [];
            if(!empty($q)){
                $transactions = $query->where(function ($query) use ($q){
                    $query->where('transactions.ref_no', 'like', '%'. $q .'%')
                        ->orWhere('c.name', 'like', '%'. $q. '%')
                        ->orWhere('c.supplier_business_name', 'like', '%'. $q .'%');
                });
            }

            $transactions = $transactions->select(
                "transactions.id",
                DB::raw("CONCAT(c.supplier_business_name, ', ', dt.short_name, ' #', transactions.ref_no) as text")
            )->get();

            return json_encode($transactions);
        }
    }

    /**
     * GET Add expense from checks.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getAddExpense(){
        if (! auth()->user()->can('expense.access')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = auth()->user()->business_id;
        
        // Provider
        $document = DocumentType::where('is_document_sale', 1)->select('id', 'document_name')->pluck('document_name', 'id');
        $business_locations = BusinessLocation::where('business_id', $business_id)->first();
        $payment_term = PaymentTerm::where('business_id', $business_id)->pluck('name', 'id');
        $tax_groups = $this->taxUtil->getTaxGroups($business_id, 'products', true);
        $payment_condition = ['cash' => __('order.cash'), 'credit' => __('order.credit')];
        $payment_terms = PaymentTerm::forDropdown($business_id);

        return view("expense.partials.add_expense")
            ->with(compact('document', 'business_locations', 'payment_term', 'tax_groups', 'payment_condition', 'payment_terms'));
    }

    /**
     * Get expense details.
     * 
     * @param  int $expense_id
     * @return json
     */
    public function getExpenseDetails($expense_id){
        $business_id = request()->session()->get("user.business_id");

        $expense = Transaction::where('transactions.business_id', $business_id)
            ->join("contacts as c", "transactions.contact_id", "c.id")
            ->whereIn('transactions.type', ['expense', 'purchase'])
            ->where('transactions.id', $expense_id)
            ->select(
                "c.id as contact_id",
                "transactions.id",
                "transactions.expense_category_id",
                "transactions.transaction_date",
                "transactions.document_types_id",
                "transactions.ref_no",
                "transactions.payment_condition",
                "transactions.payment_term_id",
                "transactions.total_before_tax",
                "transactions.tax_id",
                "transactions.tax_amount",
                "transactions.final_total",
                "transactions.additional_notes",
                "transactions.document",
                "c.supplier_business_name as supplier_name"
            )
            ->first();

        $expense->transaction_date = $this->transactionUtil->format_date($expense->transaction_date);

        return json_encode($expense);
    }

    /**
     * Pass value from tax_amount column to tax_group_amount column.
     * 
     * @return string
     */
    public function updateTaxes()
    {
        try {
            DB::beginTransaction();

            \Log::info('--- START ---');

            $expenses = Transaction::where('type', 'expense')->get();

            foreach ($expenses as $expense) {
                if (is_null($expense->tax_id) && is_null($expense->tax_group_amount)) {
                    $expense->tax_group_amount = $expense->tax_amount;
                    $expense->tax_amount = null;
                    $expense->save();

                    \Log::info('EXPENSE: ' . $expense->id);
                }
            }

            \Log::info('--- END ---');

            DB::commit();

            $output = 'SUCCESS';

        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::emergency('File: ' . $e->getFile() . ' Line: ' . $e->getLine() . ' Message: ' . $e->getMessage());

            $output = 'FAIL';
        }

        return $output;
    }

    /**
     * Function to fix value of the final total of expenses and amount of
     * payments due to bug in expense form.
     * 
     * @return string
     */
    public function setFinalTotalFromExpenses()
    {
        try {
            DB::beginTransaction();

            \Log::info('--- START ---');

            $expenses = Transaction::where('type', 'expense')
                ->where('final_total', 0)
                ->get();

            foreach ($expenses as $expense) {
                if ($expense->contact_id) {
                    $supplier = Contact::where('id', $expense->contact_id)->first();

                    $tax_percent = $this->taxUtil->getTaxPercent($supplier->tax_group_id);

                    $tax_supplier_percent = $tax_percent ?? 0;

                    $tax_supplier = 0;

                    if ($tax_supplier_percent != "0") {
                        if ($expense->total_before_tax > 0) {
                            $min_amount = $this->taxUtil->getTaxMinAmount($supplier->tax_group_id);
                            $max_amount = $this->taxUtil->getTaxMaxAmount($supplier->tax_group_id);

                            $tax_supplier = $this->calcContactTax($expense->total_before_tax, $min_amount, $max_amount, $tax_supplier_percent);

                            $expense->tax_amount = $tax_supplier;
                        }

                    } else {
                        $expense->tax_amount = $tax_supplier;
                    }

                    if ($expense->tax_id) {
                        $percent = 13;
                        $total = ($expense->total_before_tax * (($percent / 100) + 1)) + $expense->exempt_amount + $tax_supplier;
                        $tax = $total - $expense->total_before_tax - $expense->exempt_amount - $tax_supplier;

                        $expense->final_total = $total;
                        $expense->tax_group_amount = $tax;

                    } else {
                        $expense->final_total = $expense->total_before_tax + $expense->exempt_amount + $tax_supplier;
                        $expense->tax_group_amount = 0;
                    }

                    $expense->save();

                    \Log::info("EXPENSE: " . $expense->id);
                }

                $payments = TransactionPayment::where('transaction_id', $expense->id)->get();

                if ($payments->count() == 1) {
                    $payment = $payments->first();

                    if ($payment->amount == 0 && $expense->payment_status == 'paid') {
                        $payment->amount = $expense->final_total;
                        $payment->save();

                        \Log::info("PAYMENT: " . $payment->id);
                    }
                }
            }

            \Log::info('--- END ---');

            DB::commit();

            $output = 'SUCCESS';

        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::emergency('File: ' . $e->getFile(). ' Line: ' . $e->getLine(). ' Message: ' . $e->getMessage());

            $output = 'FAIL';
        }

        return $output;
    }

    /**
     * Calculate perception value.
     * 
     * @param  float  $amount
     * @param  float  $min_amount
     * @param  float  $max_amount
     * @param  float  $tax_percent
     * @return float
     */
    public function calcContactTax($amount, $min_amount, $max_amount, $tax_percent)
    {
        $tax_amount = 0;

        // If has min o max amount
        if ($min_amount || $max_amount) {
            // if has min and max amount
            if ($min_amount && $max_amount) {
                if ($amount >= $min_amount && $amount <= $max_amount) {
                    $tax_amount = $amount * $tax_percent;
                }

            // If has only min amount
            } else if ($min_amount && ! $max_amount) {
                if ($amount >= $min_amount) {
                    $tax_amount = $amount * $tax_percent;
                }

            // If has only max amount
            } else if (! $min_amount && $max_amount) {
                if ($amount <= $max_amount) {
                    $tax_amount = $amount * $tax_percent;
                }
            }

        // If has none tax
        } else {
            $tax_amount = $amount * $tax_percent;
        }

        return $tax_amount;
    }
}