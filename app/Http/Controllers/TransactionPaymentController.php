<?php

namespace App\Http\Controllers;

use App\Events\TransactionPaymentAdded;
use App\Events\TransactionPaymentDeleted;
use App\Events\TransactionPaymentUpdated;
use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\BusinessLocation;
use App\Models\Cashier;
use App\Models\CashRegister;
use App\Models\CashRegisterTransaction;
use App\Models\Contact;
use App\Models\DocumentCorrelative;
use App\Models\DocumentType;
use App\Models\Pos;
use App\Models\Quote;
use App\Models\Transaction;
use App\Models\TransactionPayment;
use App\Utils\CashRegisterUtil;
use App\Utils\ModuleUtil;
use App\Utils\TransactionUtil;
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionPaymentController extends Controller
{
    protected $transactionUtil;

    protected $moduleUtil;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct(TransactionUtil $transactionUtil, ModuleUtil $moduleUtil, CashRegisterUtil $cashRegisterUtil)
    {
        $this->transactionUtil = $transactionUtil;
        $this->moduleUtil = $moduleUtil;
        $this->cashRegisterUtil = $cashRegisterUtil;

        // Payment note short name
        $this->note_name = 'NA';
    }

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
    public function store(Request $request): RedirectResponse
    {
        if (! auth()->user()->can('purchase.payments') && ! auth()->user()->can('sell.create_payments')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $business_id = $request->session()->get('user.business_id');
            $transaction_id = $request->input('transaction_id');
            $transaction = Transaction::where('business_id', $business_id)->findOrFail($transaction_id);

            if ($transaction->payment_status != 'paid') {
                $inputs = $request->only([
                    'amount',
                    'method',
                    'paid_on',
                    'card_holder_name',
                    'card_transaction_number',
                    'card_pos',
                    'card_month',
                    'card_year',
                    'card_security',
                    'paid_on',
                    'card_authotization_number',
                    'check_number',
                    'check_account',
                    'check_bank',
                    'check_account_owner',
                    'transfer_ref_no',
                    'transfer_issuing_bank',
                    'transfer_destination_account',
                    'transfer_receiving_bank',
                    'note',
                ]);

                if (config('app.business') == 'optics') {
                    $inputs['cashier_id'] = $request->input('cashier_id');
                }

                $inputs['paid_on'] = \Carbon::createFromFormat('m/d/Y', $request->input('paid_on'))->toDateTimeString();
                $inputs['transaction_id'] = $transaction->id;
                $inputs['amount'] = $this->transactionUtil->num_uf($inputs['amount']);
                $inputs['created_by'] = auth()->user()->id;
                $inputs['payment_for'] = $transaction->contact_id;

                if (! empty($request->input('account_id'))) {
                    $inputs['account_id'] = $request->input('account_id');
                }

                $prefix_type = 'purchase_payment';

                if (in_array($transaction->type, ['sell', 'sell_return'])) {
                    $prefix_type = 'sell_payment';

                } elseif ($transaction->type == 'expense') {
                    $prefix_type = 'expense_payment';
                }

                DB::beginTransaction();

                $ref_count = $this->transactionUtil->setAndGetReferenceCount($prefix_type);

                // Generate reference number
                $inputs['transfer_ref_no'] = $this->transactionUtil->generateReferenceNumber($prefix_type, $ref_count);

                $inputs['business_id'] = $request->session()->get('business.id');
                $inputs['document'] = $this->transactionUtil->uploadFile($request, 'document', 'documents');

                $payment[] = [
                    'is_return' => 0,
                    'amount' => $inputs['amount'],
                    'method' => $inputs['method'],
                ];

                $inputs['amount'] = $this->transactionUtil->convertPayment($transaction_id, $inputs['amount']);

                $tp = TransactionPayment::create($inputs);

                // Update payment balance
                $transaction->payment_balance += $tp->amount;
                $transaction->save();

                if (config('app.business') == 'optics' && $transaction->type == 'sell') {
                    // Update payment note correlative
                    $payment_note_id = DocumentType::where('business_id', $business_id)
                        ->where('short_name', $this->note_name)
                        ->first()
                        ->id;

                    $payment_note_correlative = DocumentCorrelative::where('business_id', $business_id)
                        ->where('location_id', $tp->transaction->location_id)
                        ->whereRaw('initial <= final')
                        ->where('document_type_id', $payment_note_id)
                        ->where('status', 'active')
                        ->first();

                    if (! empty($payment_note_correlative)) {
                        if ($payment_note_correlative->actual < $payment_note_correlative->final) {
                            $payment_note_correlative->actual += 1;
                            $payment_note_correlative->save();

                        } elseif ($payment_note_correlative->actual == $payment_note_correlative->final) {
                            $payment_note_correlative->status = 'inactive';
                            $payment_note_correlative->save();
                        }
                    }
                }

                $final_total = $transaction->purchase_type == 'international' ? $transaction->total_after_expense : $transaction->final_total;

                // Update payment status
                $status = $this->transactionUtil->updatePaymentStatus($transaction_id, $final_total);

                /*if($transaction->type == 'sell') {
                    if ($status != 'paid' && $transaction->payment_condition == 'credit') {
                        $total_paid = $this->transactionUtil->getTotalPaid($transaction->id);
                        $this->cashRegisterUtil->addCreditSellPayment($transaction, $total_paid, $transaction->final_total);
                    } else {
                        $this->cashRegisterUtil->addSellPayments($transaction, $payment);
                    }
                }*/

                //$this->transactionUtil->updatePaymentStatus($transaction_id);

                if (config('app.business') == 'optics') {
                    // Create payment
                    $payments = [$tp];
                    $this->cashRegisterUtil->addSellPayments($transaction, $payments);

                    // Update credit
                    $credit_register = CashRegisterTransaction::where('transaction_id', $transaction->id)
                        ->where('pay_method', 'credit')
                        ->first();

                    if (! empty($credit_register)) {
                        $credit_register->amount -= $tp->amount;
                        $credit_register->save();
                    }
                }

                DB::commit();

                $inputs['transaction_type'] = $transaction->type;

                event(new TransactionPaymentAdded($tp, $inputs));
            }

            $output = [
                'success' => true,
                'msg' => __('purchase.payment_added_success'),
            ];

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::emergency('File: '.$e->getFile().' Line: '.$e->getLine().' Message: '.$e->getMessage());

            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return redirect()->back()->with(['status' => $output]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): View
    {
        if (! auth()->user()->can('purchase.create') && ! auth()->user()->can('sell.view_payments')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $transaction = Transaction::where('id', $id)
                ->with(['business'])
                ->first();

            $payments_query = TransactionPayment::where('transaction_id', $id);

            // $customer = $this->transactionUtil->getCustomerInfo($transaction->customer_id);

            $accounts_enabled = false;

            if ($this->moduleUtil->isModuleDefined('Account')) {
                $accounts_enabled = true;
                $payments_query->with(['payment_account']);
            }

            $payments = $payments_query->get();

            $payment_types = $this->transactionUtil->payment_types();

            // Indicate if it is a transaction or a quote
            $entity_type = 'transaction';

            return view('transaction_payment.show_payments')
                ->with(compact(
                    'transaction',
                    'payments',
                    'payment_types',
                    'accounts_enabled',
                    'entity_type'
                ));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id, string $entity_type = 'transaction'): View
    {
        if (! auth()->user()->can('purchase.create') && ! auth()->user()->can('$sell.create_payments')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');

            $payment_line = TransactionPayment::findOrFail($id);

            // Get transaction
            if ($entity_type == 'transaction') {
                $transaction = Transaction::where('id', $payment_line->transaction_id)
                    ->where('business_id', $business_id)
                    ->with(['contact', 'location'])
                    ->first();

                // Get quote
            } else {
                $transaction = Quote::where('id', $payment_line->quote_id)
                    ->where('business_id', $business_id)
                    ->with(['location'])
                    ->first();
            }

            $payment_types = $this->transactionUtil->payment_types();

            // Accounts
            $accounts = $this->moduleUtil->accountsDropdown($business_id, true);

            // Pos
            $pos = Pos::where('business_id', $business_id)->pluck('name', 'id');

            // Banks
            $banks = Bank::where('business_id', $business_id)
                ->pluck('name', 'id');

            // Bank account
            $bank_accounts = BankAccount::pluck('name', 'id');

            if (config('app.business') == 'optics') {
                // Cashiers
                $cashiers = Cashier::forDropdown($business_id, false);

                $default_cashier = null;

                if (count($cashiers) == 1) {
                    foreach ($cashiers as $id => $name) {
                        $default_cashier = $id;
                    }
                }

                // Locations
                $locations = BusinessLocation::forDropdown($business_id, false, false);

                $default_location = null;

                // Access only to one locations
                if (count($locations) == 1) {
                    foreach ($locations as $id => $name) {
                        $default_location = $id;
                    }

                    // Access to all locations
                } elseif (auth()->user()->permitted_locations() == 'all') {
                    $locations = $locations->prepend(__('kardex.all_2'), 'all');
                }

                // Payment note document
                $payment_note_id = DocumentType::where('business_id', $business_id)
                    ->where('short_name', $this->note_name)
                    ->first()
                    ->id;

                return view('transaction_payment.edit_payment_row')
                    ->with(compact(
                        'transaction',
                        'payment_types',
                        'pos',
                        'banks',
                        'payment_line',
                        'accounts',
                        'entity_type',
                        'cashiers',
                        'default_cashier',
                        'locations',
                        'default_location',
                        'payment_note_id',
                        'bank_accounts'
                    ));

            } else {
                return view('transaction_payment.edit_payment_row')
                    ->with(compact(
                        'transaction',
                        'payment_types',
                        'pos',
                        'banks',
                        'payment_line',
                        'accounts',
                        'entity_type',
                        'bank_accounts'
                    ));
            }
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        if (! auth()->user()->can('purchase.payments') && ! auth()->user()->can('sell.create_payments')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $input = [];

            switch ($request->method) {
                case 'cash':
                    $input = [
                        'amount',
                        'method',
                        'paid_on',
                        'note',
                    ];
                    break;

                case 'card':
                    $input = [
                        'amount',
                        'method',
                        'card_number',
                        'card_holder_name',
                        'card_transaction_number',
                        'card_pos',
                        'card_month',
                        'card_year',
                        'card_security',
                        'paid_on',
                        'card_authotization_number',
                        'note',
                    ];
                    break;

                case 'check':
                    $input = [
                        'method',
                        'amount',
                        'check_number',
                        'check_account',
                        'check_bank',
                        'check_account_owner',
                        'paid_on',
                        'note',
                    ];
                    break;

                case 'bank_transfer':
                    $input = [
                        'amount',
                        'transfer_ref_no',
                        'transfer_issuing_bank',
                        'transfer_destination_account',
                        'transfer_receiving_bank',
                        'paid_on',
                        'method',
                        'note',
                    ];
                    break;
            }

            $inputs = $request->only($input);

            // Indicate if it is a transaction or a quote
            $entity_type = $request->input('entity_type');

            $inputs['paid_on'] = \Carbon::createFromFormat('m/d/Y', $request->input('paid_on'))->toDateTimeString();
            $inputs['amount'] = $this->transactionUtil->num_uf($inputs['amount']);

            if (! empty($request->input('account_id'))) {
                $inputs['account_id'] = $request->input('account_id');
            }

            $payment = TransactionPayment::findOrFail($id);

            $payment_before = $payment->amount;

            $business_id = $request->session()->get('user.business_id');

            // Get transaction
            if ($entity_type == 'transaction') {
                $transaction = Transaction::where('business_id', $business_id)
                    ->find($payment->transaction_id);

                // Get quote
            } else {
                $transaction = Quote::where('business_id', $business_id)
                    ->find($payment->quote_id);
            }

            if ($entity_type == 'transaction') {
                $inputs['amount'] = $this->transactionUtil->convertPayment($transaction->id, $inputs['amount'], $payment->amount);
            }

            $document_name = $this->transactionUtil->uploadFile($request, 'document', 'documents');

            if (! empty($document_name)) {
                $inputs['document'] = $document_name;
            }

            DB::beginTransaction();

            if (config('app.business') == 'optics') {
                // Update payment and cash register transaction
                if ($entity_type == 'transaction') {
                    $register = CashRegisterTransaction::where('transaction_id', $payment->transaction_id)
                        ->where('pay_method', $payment->method)
                        ->where('amount', $payment->amount)
                        ->first();

                    $credit_register = CashRegisterTransaction::where('transaction_id', $payment->transaction_id)
                        ->where('pay_method', 'credit')
                        ->first();

                } else {
                    $register = CashRegisterTransaction::where('quote_id', $payment->quote_id)
                        ->where('pay_method', $payment->method)
                        ->where('amount', $payment->amount)
                        ->first();

                    $credit_register = CashRegisterTransaction::where('quote_id', $payment->quote_id)
                        ->where('pay_method', 'credit')
                        ->first();
                }
            }

            $payment_method = (object) $inputs;

            // Update payment methods
            $this->transactionUtil->updatePaymentsMethod($payment->id, $payment_method);

            // Update payment balance
            if ($entity_type == 'transaction') {
                $transaction->payment_balance = ($transaction->payment_balance - $payment_before) + $inputs['amount'];
            }

            $transaction->save();

            if (config('app.business') == 'optics') {
                if (! empty($register)) {
                    // Update payment register
                    $difference = $register->amount - $payment->amount;

                    $register->pay_method = $payment->method;
                    $register->amount = $payment->amount;
                    $register->save();

                    // Update credit
                    if (! empty($credit_register)) {
                        $credit_register->amount += $difference;
                        $credit_register->save();
                    }
                }
            }

            // Update payment status
            if ($entity_type == 'transaction') {
                $this->transactionUtil->updatePaymentStatus(
                    $payment->transaction_id
                    // $transaction->final_total
                );
            }

            DB::commit();

            // Event
            if ($entity_type == 'transaction') {
                event(new TransactionPaymentUpdated($payment, $transaction->type));
            }

            $output = [
                'success' => true,
                'msg' => __('purchase.payment_updated_success'),
            ];

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::emergency('File: '.$e->getFile().' Line: '.$e->getLine().' Message: '.$e->getMessage());

            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return redirect()->back()->with(['status' => $output]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id, string $entity_type = 'transaction')
    {
        if (! auth()->user()->can('purchase.payments') && ! auth()->user()->can('sell.delete_payments')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $business_id = auth()->user()->business_id;

                $payment = TransactionPayment::findOrFail($id);

                $transaction = Transaction::where('id', $payment->transaction_id)
                    ->where('business_id', $business_id)
                    //->where('type', 'sell')
                    ->first();

                // Update payment balance
                if (! empty($transaction)) {
                    $transaction->payment_balance -= $payment->amount;
                    $transaction->save();
                }

                if (config('app.business') == 'optics') {
                    // Delete cash register transaction for transaction
                    if ($entity_type == 'transaction') {
                        $register = CashRegisterTransaction::where('transaction_id', $payment->transaction_id)
                            ->where('pay_method', $payment->method)
                            ->where('amount', $payment->amount)
                            ->first();

                        $credit_register = CashRegisterTransaction::where('transaction_id', $payment->transaction_id)
                            ->where('pay_method', 'credit')
                            ->first();

                        // Delete cash register transaction quote
                    } else {
                        $register = CashRegisterTransaction::where('quote_id', $payment->quote_id)
                            ->where('pay_method', $payment->method)
                            ->where('amount', $payment->amount)
                            ->first();

                        $credit_register = CashRegisterTransaction::where('quote_id', $payment->quote_id)
                            ->where('pay_method', 'credit')
                            ->first();
                    }

                    if (! empty($register)) {
                        // Update credit
                        if (! empty($credit_register)) {
                            $credit_register->amount += $register->amount;
                            $credit_register->save();
                        }

                        $register->delete();
                    }
                }

                $payment->delete();

                // Refund sell on cash register
                if (config('app.business') != 'optics') {
                    if (! empty($transaction)) {
                        $refund_sell = $this->cashRegisterUtil->refundSell($transaction);

                        if (! $refund_sell) {
                            return $output = [
                                'success' => false,
                                'msg' => __('cash_register.cash_register_not_opened'),
                            ];
                        }
                    }
                }

                if ($entity_type == 'transaction') {
                    // Update payment status
                    $this->transactionUtil->updatePaymentStatus($payment->transaction_id);

                    event(new TransactionPaymentDeleted($payment->id, $payment->account_id));
                }

                $output = [
                    'success' => true,
                    'msg' => __('purchase.payment_deleted_success'),
                ];

            } catch (\Exception $e) {
                \Log::emergency('File: '.$e->getFile().' Line: '.$e->getLine().' Message: '.$e->getMessage());

                $output = [
                    'success' => false,
                    'msg' => __('messages.something_went_wrong'),
                ];
            }

            return $output;
        }
    }

    /**
     * Adds new payment to the given transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function addPayment(int $transaction_id)
    {
        if (! auth()->user()->can('purchase.payments') && ! auth()->user()->can('sell.payments')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');

            $transaction = Transaction::where('id', $transaction_id)
                ->where('business_id', $business_id)
                ->with(['contact', 'location'])
                ->first();

            if (config('app.business') == 'optics') {
                if ($transaction->type == 'sell') {
                    $register = CashRegister::where('cashier_id', $transaction->cashier_id)
                        ->where('status', 'open')
                        ->first();

                    if (empty($register)) {
                        $output = [
                            'status' => 'paid',
                            'view' => '',
                            'msg' => __('cash_register.cash_register_not_opened'),
                        ];

                        return json_encode($output);
                    }
                }
            }

            if ($transaction->payment_status != 'paid') {
                $payment_types = $this->transactionUtil->payment_types();

                if ($transaction->type == 'sell') {
                    $paid_amount = $transaction->payment_balance;
                } else {
                    $paid_amount = $this->transactionUtil->getTotalPaid($transaction_id);
                }

                $final_total = $transaction->purchase_type == 'international' ? $transaction->total_after_expense : $transaction->final_total;

                $amount = $final_total - $paid_amount;

                if ($amount < 0) {
                    $amount = 0;
                }

                $amount_formated = $this->transactionUtil->num_f($amount);

                $payment_line = new TransactionPayment();
                $payment_line->amount = $amount;
                $payment_line->method = 'cash';
                $payment_line->paid_on = \Carbon::now()->toDateString();

                // Accounts
                $accounts = $this->moduleUtil->accountsDropdown($business_id, true);

                // Pos
                $pos = Pos::where('business_id', $business_id)->pluck('name', 'id');

                // Banks
                $banks = Bank::where('business_id', $business_id)
                    ->pluck('name', 'id');

                /** Bank account */
                $bank_accounts = BankAccount::pluck('name', 'id');

                if (config('app.business') == 'optics') {
                    // Cashiers
                    $cashiers = Cashier::forDropdown($business_id, false);

                    $default_cashier = null;

                    if (count($cashiers) == 1) {
                        foreach ($cashiers as $id => $name) {
                            $default_cashier = $id;
                        }
                    }

                    // Payment note correlative
                    $payment_note_id = DocumentType::where('business_id', $business_id)
                        ->where('short_name', $this->note_name)
                        ->first()
                        ->id;

                    $correlative_obj = DB::table('document_correlatives')
                        ->where('document_type_id', $payment_note_id)
                        ->where('location_id', $transaction->location_id)
                        ->where('status', 'active')
                        ->where('business_id', $business_id)
                        ->select('actual')
                        ->first();

                    if (! empty($correlative_obj->actual)) {
                        $correlative = $correlative_obj->actual;
                    } else {
                        $correlative = '0';
                    }

                    // Locations
                    $locations = BusinessLocation::forDropdown($business_id, false, false);

                    $default_location = null;

                    // Access only to one locations
                    if (count($locations) == 1) {
                        foreach ($locations as $id => $name) {
                            $default_location = $id;
                        }

                        // Access to all locations
                    } elseif (auth()->user()->permitted_locations() == 'all') {
                        $locations = $locations->prepend(__('kardex.all_2'), 'all');
                    }

                    // Payment note document
                    $payment_note_id = DocumentType::where('business_id', $business_id)
                        ->where('short_name', $this->note_name)
                        ->first()
                        ->id;

                    $view = view('transaction_payment.payment_row')
                        ->with(compact(
                            'transaction',
                            'payment_types',
                            'pos',
                            'banks',
                            'bank_accounts',
                            'payment_line',
                            'amount_formated',
                            'accounts',
                            'payment_note_id',
                            'cashiers',
                            'default_cashier',
                            'correlative',
                            'locations',
                            'default_location'
                        ))->render();

                } else {
                    $view = view('transaction_payment.payment_row')
                        ->with(compact(
                            'transaction',
                            'payment_types',
                            'pos',
                            'banks',
                            'bank_accounts',
                            'payment_line',
                            'amount_formated',
                            'accounts'
                        ))->render();
                }

                $output = [
                    'status' => 'due',
                    'view' => $view,
                ];

            } else {
                $output = [
                    'status' => 'paid',
                    'view' => '',
                    'msg' => __('purchase.amount_already_paid'),
                ];
            }

            return json_encode($output);
        }
    }

    /**
     * Get multipayment view
     */
    public function multiPayments(): View
    {
        if (! auth()->user()->can('sell.create_payments')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = auth()->user()->business_id;

        $payment_methods = $this->transactionUtil->payment_types();
        $pos = Pos::where('business_id', $business_id)->pluck('name', 'id');
        $banks = Bank::where('business_id', $business_id)->pluck('name', 'id');
        $bank_accounts = BankAccount::where('business_id', $business_id)->pluck('name', 'id');

        return view('transaction_payment.multi_payments',
            compact('payment_methods', 'pos', 'banks', 'bank_accounts'));
    }

    /**
     * Store multi payments
     *
     * @param \Illuminate\Http\Request
     */
    public function storeMultiPayments(Request $request): json
    {
        if (! auth()->user()->can('sell.create_payments')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();

            $created_by = auth()->user()->id;
            $business_id = auth()->user()->business_id;
            $payment_for = $request->get('customer');
            $prefix_type = 'sell_payment';

            $paid_on = $this->transactionUtil->uf_date($request->input('paid_on'));
            $method = $request->input('method');
            $payments = $request->input('payments');
            $payment = [
                'method' => $request->input('method'),
                'paid_on' => $paid_on,
                'card_holder_name' => $request->input('card_holder_name'),
                'card_authotization_number' => $request->input('card_authotization_number'),
                'card_type' => $request->input('card_type'),
                'card_pos' => $request->input('card_pos'),
                'check_number' => $request->input('check_number'),
                'check_account' => $request->input('check_account'),
                'check_bank' => $request->input('check_bank'),
                'check_account_owner' => $request->input('check_account_owner'),
                'transfer_issuing_bank' => $request->input('transfer_issuing_bank'),
                'transfer_destination_account' => null,
                'transfer_receiving_bank' => $request->input('transfer_receiving_bank'),
                'note' => $request->input('note'),
                'created_by' => $created_by,
                'business_id' => $business_id,
                'payment_for' => $payment_for,
                'document' => $this->transactionUtil->uploadFile($request, 'document', 'documents'),
            ];

            foreach ($payments as $p) {
                $transaction_id = $p['transaction_id'];
                $transaction = Transaction::where('business_id', $business_id)
                    ->findOrFail($transaction_id);
                $ref_count = $this->transactionUtil->setAndGetReferenceCount($prefix_type);
                $payment_ref_no = $this->transactionUtil->generateReferenceNumber($prefix_type, $ref_count);

                $payment['transaction_id'] = $transaction_id;
                $payment['amount'] = $this->transactionUtil->convertPayment($transaction_id, $p['amount']);
                $payment['payment_ref_no'] = $payment_ref_no;

                $tp = TransactionPayment::create($payment);

                $transaction->payment_balance += $tp->amount;
                $transaction->save();

                $this->transactionUtil->updatePaymentStatus($transaction_id);
            }

            DB::commit();

            $output = [
                'success' => true,
                'msg' => __('payment.payments_added_success'),
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return $output;
    }

    /**
     * Shows contact's payment due modal
     */
    public function getPayContactDue(int $contact_id): View
    {
        if (! auth()->user()->can('purchase.create') && ! auth()->user()->can('sell.create')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');

            $due_payment_type = request()->input('type');
            $query = Contact::where('contacts.id', $contact_id)
                ->join('transactions AS t', 'contacts.id', '=', 't.contact_id');
            if ($due_payment_type == 'purchase') {
                $query->select(
                    DB::raw("SUM(IF(t.type = 'purchase', final_total, 0)) as total_purchase"),
                    DB::raw("SUM(IF(t.type = 'purchase', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as total_paid"),
                    'contacts.name',
                    'contacts.supplier_business_name',
                    'contacts.id as contact_id'
                );
            } elseif ($due_payment_type == 'purchase_return') {
                $query->select(
                    DB::raw("SUM(IF(t.type = 'purchase_return', final_total, 0)) as total_purchase_return"),
                    DB::raw("SUM(IF(t.type = 'purchase_return', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as total_return_paid"),
                    'contacts.name',
                    'contacts.supplier_business_name',
                    'contacts.id as contact_id'
                );
            } elseif ($due_payment_type == 'sell') {
                $query->select(
                    DB::raw("SUM(IF(t.type = 'sell' AND t.status = 'final', final_total, 0)) as total_invoice"),
                    DB::raw("SUM(IF(t.type = 'sell' AND t.status = 'final', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as total_paid"),
                    'contacts.name',
                    'contacts.supplier_business_name',
                    'contacts.id as contact_id'
                );
            } elseif ($due_payment_type == 'sell_return') {
                $query->select(
                    DB::raw("SUM(IF(t.type = 'sell_return', final_total, 0)) as total_sell_return"),
                    DB::raw("SUM(IF(t.type = 'sell_return', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as total_return_paid"),
                    'contacts.name',
                    'contacts.supplier_business_name',
                    'contacts.id as contact_id'
                );
            }

            //Query for opening balance details
            $query->addSelect(
                DB::raw("SUM(IF(t.type = 'opening_balance', final_total, 0)) as opening_balance"),
                DB::raw("SUM(IF(t.type = 'opening_balance', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as opening_balance_paid")
            );
            $contact_details = $query->first();

            $payment_line = new TransactionPayment();
            if ($due_payment_type == 'purchase') {
                $contact_details->total_purchase = empty($contact_details->total_purchase) ? 0 : $contact_details->total_purchase;
                $payment_line->amount = $contact_details->total_purchase -
                    $contact_details->total_paid;
            } elseif ($due_payment_type == 'purchase_return') {
                $payment_line->amount = $contact_details->total_purchase_return -
                    $contact_details->total_return_paid;
            } elseif ($due_payment_type == 'sell') {
                $contact_details->total_invoice = empty($contact_details->total_invoice) ? 0 : $contact_details->total_invoice;

                $payment_line->amount = $contact_details->total_invoice -
                    $contact_details->total_paid;
            } elseif ($due_payment_type == 'sell_return') {
                $payment_line->amount = $contact_details->total_sell_return -
                    $contact_details->total_return_paid;
            }

            //If opening balance due exists add to payment amount
            $contact_details->opening_balance = ! empty($contact_details->opening_balance) ? $contact_details->opening_balance : 0;
            $contact_details->opening_balance_paid = ! empty($contact_details->opening_balance_paid) ? $contact_details->opening_balance_paid : 0;
            $ob_due = $contact_details->opening_balance - $contact_details->opening_balance_paid;
            if ($ob_due > 0) {
                $payment_line->amount += $ob_due;
            }

            $amount_formated = $this->transactionUtil->num_f($payment_line->amount);

            $contact_details->total_paid = empty($contact_details->total_paid) ? 0 : $contact_details->total_paid;

            $payment_line->method = 'cash';
            $payment_line->paid_on = \Carbon::now()->toDateString();

            $payment_types = $this->transactionUtil->payment_types();

            //Accounts
            $accounts = $this->moduleUtil->accountsDropdown($business_id, true);

            // Pos
            $pos = Pos::where('business_id', $business_id)->pluck('name', 'id');

            // Banks
            $banks = Bank::where('business_id', $business_id)->pluck('name', 'id');

            if ($payment_line->amount > 0) {
                return view('transaction_payment.pay_supplier_due_modal')
                    ->with(compact(
                        'contact_details',
                        'payment_types',
                        'payment_line',
                        'due_payment_type',
                        'ob_due',
                        'amount_formated',
                        'accounts',
                        'pos',
                        'banks'
                    ));
            }
        }
    }

    /**
     * Adds Payments for Contact due
     */
    public function postPayContactDue(Request $request): RedirectResponse
    {
        if (! auth()->user()->can('purchase.create') && ! auth()->user()->can('sell.create')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $contact_id = $request->input('contact_id');
            $inputs = $request->only([
                'amount',
                'method',
                'paid_on',
                'card_holder_name',
                'card_transaction_number',
                'card_pos',
                'card_month',
                'card_year',
                'card_security',
                'paid_on',
                'card_authotization_number',
                'check_number',
                'check_account',
                'check_bank',
                'check_account_owner',
                'transfer_ref_no',
                'transfer_issuing_bank',
                'transfer_destination_account',
                'transfer_receiving_bank',
            ]);
            $inputs['paid_on'] = \Carbon::createFromFormat('m/d/Y', $request->input('paid_on'))->toDateTimeString();
            $inputs['amount'] = $this->transactionUtil->num_uf($inputs['amount']);
            $inputs['created_by'] = auth()->user()->id;
            $inputs['payment_for'] = $contact_id;
            $inputs['business_id'] = $request->session()->get('business.id');

            if ($inputs['method'] == 'custom_pay_1') {
                $inputs['transaction_no'] = $request->input('transaction_no_1');
            } elseif ($inputs['method'] == 'custom_pay_2') {
                $inputs['transaction_no'] = $request->input('transaction_no_2');
            } elseif ($inputs['method'] == 'custom_pay_3') {
                $inputs['transaction_no'] = $request->input('transaction_no_3');
            }
            $due_payment_type = $request->input('due_payment_type');

            $prefix_type = 'purchase_payment';
            if (in_array($due_payment_type, ['sell', 'sell_return'])) {
                $prefix_type = 'sell_payment';
            }
            $ref_count = $this->transactionUtil->setAndGetReferenceCount($prefix_type);
            //Generate reference number
            $payment_ref_no = $this->transactionUtil->generateReferenceNumber($prefix_type, $ref_count);

            $inputs['payment_ref_no'] = $payment_ref_no;

            if (! empty($request->input('account_id'))) {
                $inputs['account_id'] = $request->input('account_id');
            }

            //Upload documents if added
            $inputs['document'] = $this->transactionUtil->uploadFile($request, 'document', 'documents');

            DB::beginTransaction();

            $parent_payment = TransactionPayment::create($inputs);

            $inputs['transaction_type'] = $due_payment_type;

            event(new TransactionPaymentAdded($parent_payment, $inputs));

            //Distribute above payment among unpaid transactions

            $this->transactionUtil->payAtOnce($parent_payment, $due_payment_type);

            DB::commit();
            $output = [
                'success' => true,
                'msg' => __('purchase.payment_added_success'),
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return redirect()->back()->with(['status' => $output]);
    }

    /**
     * view details of single..,
     * payment.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function viewPayment($payment_id, string $entity_type = null): View
    {
        // if (!auth()->user()->can('purchase.payments') && !auth()->user()->can('sell.payments')) {
        //     abort(403, 'Unauthorized action.');
        // }

        if (request()->ajax()) {
            $business_id = request()->session()->get('business.id');

            $single_payment_line = TransactionPayment::findOrFail($payment_id);

            $transaction = null;

            if (! empty($single_payment_line->transaction_id)) {
                $transaction = Transaction::where('id', $single_payment_line->transaction_id)
                    ->with(['contact', 'location'])
                    ->first();

            } elseif (! empty($single_payment_line->quote_id)) {
                $transaction = Quote::where('id', $single_payment_line->quote_id)
                    ->with(['location'])
                    ->first();

            } else {
                $child_payment = TransactionPayment::where('business_id', $business_id)
                    ->where('parent_id', $payment_id)
                    ->with(['transaction', 'transaction.contact', 'transaction.location'])
                    ->first();

                $transaction = $child_payment->transaction;
            }

            $payment_types = $this->transactionUtil->payment_types();

            return view('transaction_payment.single_payment_view')
                ->with(compact('single_payment_line', 'transaction', 'payment_types'));
        }
    }

    /**
     * Retrieves all the child payments of a parent payments
     * payment.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function showChildPayments($payment_id): View
    {
        if (! auth()->user()->can('purchase.payments') && ! auth()->user()->can('sell.payments')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $business_id = request()->session()->get('business.id');

            $child_payments = TransactionPayment::where('business_id', $business_id)
                ->where('parent_id', $payment_id)
                ->with(['transaction', 'transaction.contact'])
                ->get();

            $payment_types = $this->transactionUtil->payment_types();

            return view('transaction_payment.show_child_payments')
                ->with(compact('child_payments', 'payment_types'));
        }
    }

    //Editar metodos de pago
    public function editPaymentMethod($id): View
    {
        if (! auth()->user()->can('purchase.create') && ! auth()->user()->can('sell.create')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');

            $payment_line = TransactionPayment::findOrFail($id);

            $transaction = Transaction::where('id', $payment_line->transaction_id)
                ->where('business_id', $business_id)
                ->with(['contact', 'location'])
                ->first();

            $payment_types = $this->transactionUtil->payment_types();

            //Accounts
            $accounts = $this->moduleUtil->accountsDropdown($business_id, true);
            $pos = Pos::where('business_id', $business_id)->pluck('name', 'id');
            $banks = Bank::where('business_id', $business_id)
                ->pluck('name', 'id');

            return view('transaction_payment.edit_invoice_payment_row')
                ->with(compact('transaction', 'payment_types', 'pos', 'banks', 'payment_line', 'accounts'));
        }
    }

    /**
     * Add new payment to the given quote.
     *
     * @return \Illuminate\Http\Response
     */
    public function addPaymentToQuote(int $quote_id)
    {
        if (! auth()->user()->can('purchase.payments') && ! auth()->user()->can('sell.payments')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');

            // Reservation
            $reservation = Quote::where('id', $quote_id)
                ->where('business_id', $business_id)
                ->with(['location'])
                ->first();

            // Get payment status
            $status = $this->transactionUtil->calculatePaymentStatusToQuotes($reservation->id, $reservation->total_final);

            if ($status != 'paid') {
                $payment_types = $this->transactionUtil->payment_types();

                $paid_amount = $this->transactionUtil->getTotalPaidToQuotes($quote_id);

                // Calculate amount
                $amount = $reservation->total_final - $paid_amount;

                if ($amount < 0) {
                    $amount = 0;
                }

                $amount_formated = $this->transactionUtil->num_f($amount);

                $payment_line = new TransactionPayment();
                $payment_line->amount = $amount;
                $payment_line->method = 'cash';
                $payment_line->paid_on = \Carbon::now()->toDateString();

                // Accounts
                $accounts = $this->moduleUtil->accountsDropdown($business_id, true);

                // Banks
                $banks = Bank::where('business_id', $business_id)
                    ->pluck('name', 'id');

                // Pos
                $pos = Pos::where('business_id', $business_id)
                    ->pluck('name', 'id');

                // Cashiers
                $cashiers = Cashier::forDropdown($business_id, false);

                // Default cashier
                $default_cashier = null;

                if (count($cashiers) == 1) {
                    foreach ($cashiers as $id => $name) {
                        $default_cashier = $id;
                    }
                }

                // Payment note correlative
                $payment_note_id = DocumentType::where('business_id', $business_id)
                    ->where('short_name', $this->note_name)
                    ->first()
                    ->id;

                $correlative_obj = DB::table('document_correlatives')
                    ->where('document_type_id', $payment_note_id)
                    ->where('location_id', $reservation->location_id)
                    ->where('status', 'active')
                    ->where('business_id', $business_id)
                    ->select('actual')
                    ->first();

                if (! empty($correlative_obj->actual)) {
                    $correlative = $correlative_obj->actual;
                } else {
                    $correlative = '0';
                }

                // Bank account
                $bank_accounts = BankAccount::pluck('name', 'id');

                $view = view('transaction_payment.payment_row_quote')
                    ->with(compact(
                        'reservation',
                        'payment_types',
                        'payment_line',
                        'amount_formated',
                        'accounts',
                        'banks',
                        'pos',
                        'cashiers',
                        'default_cashier',
                        'correlative',
                        'bank_accounts'
                    ))->render();

                $output = [
                    'status' => 'due',
                    'view' => $view,
                ];

            } else {
                $output = [
                    'status' => 'paid',
                    'view' => '',
                    'msg' => __('purchase.amount_already_paid'),
                ];
            }

            return json_encode($output);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeToQuote(Request $request): RedirectResponse
    {
        try {
            $business_id = $request->session()->get('user.business_id');

            // Quote
            $quote_id = $request->input('quote_id');
            $quote = Quote::findOrFail($quote_id);

            // Get payment status
            $status = $this->transactionUtil->calculatePaymentStatusToQuotes($quote->id, $quote->final_total);

            if ($status != 'paid') {
                $inputs = $request->only([
                    'amount',
                    'method',
                    'note',
                    'card_holder_name', /** Card */
                    'card_authotization_number',
                    'card_pos',
                    'card_authotization_number',
                    'check_number', /** Check */
                    'check_account',
                    'check_bank',
                    'check_account_owner',
                    'transfer_ref_no', /** Transfer */
                    'transfer_issuing_bank',
                    'transfer_destination_account',
                    'transfer_receiving_bank',
                    'cashier_id',
                ]);

                $inputs['paid_on'] = \Carbon::createFromFormat('m/d/Y', $request->input('paid_on'))->toDateTimeString();
                $inputs['quote_id'] = $quote->id;
                $inputs['amount'] = $this->transactionUtil->num_uf($inputs['amount']);
                $inputs['created_by'] = auth()->user()->id;

                if (! empty($request->input('account_id'))) {
                    $inputs['account_id'] = $request->input('account_id');
                }

                $prefix_type = 'reservation_payment';

                DB::beginTransaction();

                $ref_count = $this->transactionUtil->setAndGetReferenceCount($prefix_type);

                // Generate reference number
                $inputs['payment_ref_no'] = $this->transactionUtil->generateReferenceNumber($prefix_type, $ref_count);

                $inputs['business_id'] = $request->session()->get('business.id');

                // Upload document
                $inputs['document'] = $this->transactionUtil->uploadFile($request, 'document', 'documents');

                $tp = TransactionPayment::create($inputs);

                // Update payment note correlative
                $payment_note_id = DocumentType::where('business_id', $business_id)
                    ->where('short_name', $this->note_name)
                    ->first()
                    ->id;

                $payment_note_correlative = DocumentCorrelative::where('business_id', $business_id)
                    ->where('location_id', $tp->quote->location_id)
                    ->whereRaw('initial <= final')
                    ->where('document_type_id', $payment_note_id)
                    ->where('status', 'active')
                    ->first();

                if (! empty($payment_note_correlative)) {
                    if ($payment_note_correlative->actual < $payment_note_correlative->final) {
                        $payment_note_correlative->actual += 1;
                        $payment_note_correlative->save();

                    } elseif ($payment_note_correlative->actual == $payment_note_correlative->final) {
                        $payment_note_correlative->status = 'inactive';
                        $payment_note_correlative->save();
                    }
                }

                // Create payment
                $payments = [$tp];
                $this->cashRegisterUtil->addSellPaymentsToQuotes($quote, $payments);

                // Update credit
                $credit_register = CashRegisterTransaction::where('quote_id', $quote->id)
                    ->where('pay_method', 'credit')
                    ->first();

                if (! empty($credit_register)) {
                    $credit_register->amount -= $tp->amount;
                    $credit_register->save();
                }

                DB::commit();

                $inputs['transaction_type'] = $quote->type;

                event(new TransactionPaymentAdded($tp, $inputs));
            }

            $output = [
                'success' => true,
                'msg' => __('purchase.payment_added_success'),
            ];

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::emergency('File: '.$e->getFile().' Line: '.$e->getLine().' Message: '.$e->getMessage());

            $output = [
                'success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
        }

        return redirect()->back()->with(['status' => $output]);
    }

    /**
     * Display the specified resource.
     */
    public function showToQuote(int $id): View
    {
        if (! auth()->user()->can('purchase.create') && ! auth()->user()->can('sell.create')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $transaction = Quote::where('id', $id)
                ->with(['customer', 'business'])
                ->first();

            $payments_query = TransactionPayment::where('quote_id', $id);

            $accounts_enabled = false;

            if ($this->moduleUtil->isModuleDefined('Account')) {
                $accounts_enabled = true;
                $payments_query->with(['payment_account']);
            }

            $payments = $payments_query->get();

            $payment_types = $this->transactionUtil->payment_types();

            $entity_type = 'quote';

            return view('transaction_payment.show_payments')
                ->with(compact(
                    'transaction',
                    'payments',
                    'payment_types',
                    'accounts_enabled',
                    'entity_type'
                ));
        }
    }
}
