<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Models\BankTransaction;
use App\Models\TypeBankTransaction;
use DataTables;
use DB;
use Illuminate\Http\Request;

class TypeBankTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('banks.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('banks.index');
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
                'name' => 'required|unique:type_bank_transactions',
                'type' => 'required',
                'type_entrie_id' => 'required',
            ],
            [
                'name.required' => __('accounting.name_required'),
                'name.unique' => __('accounting.name_unique'),
                'type.required' => __('accounting.type_required'),
                'type_entrie_id.required' => __('accounting.type_entrie_id_required'),
            ]
        );
        $type_details = $request->only(['name', 'type', 'type_entrie_id', 'enable_checkbook', 'enable_headline', 'enable_date_constraint']);

        if ($request->ajax()) {
            try {
                $transaction_type = TypeBankTransaction::create($type_details);
                $output = [
                    'success' => true,
                    'msg' => __('accounting.added_successfully'),
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TypeBankTransaction  $typeBankTransaction
     */
    public function show($id): JsonResponse
    {
        $typeBankTransaction = TypeBankTransaction::findOrFail($id);

        return response()->json($typeBankTransaction);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TypeBankTransaction  $typeBankTransaction
     */
    public function edit($id): JsonResponse
    {
        $typeBankTransaction = TypeBankTransaction::findOrFail($id);

        return response()->json($typeBankTransaction);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\TypeBankTransaction  $typeBankTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $typeBankTransaction = TypeBankTransaction::findOrFail($id);
        $validateData = $request->validate(
            [
                'name' => 'required|unique:type_bank_transactions,name,'.$typeBankTransaction->id,
                'type_entrie_id' => 'required',
            ],
            [
                'name.required' => __('accounting.name_required'),
                'name.unique' => __('accounting.name_unique'),
                'type_entrie_id.required' => __('accounting.type_entrie_id_required'),
            ]
        );
        $type_details = $request->only(['name', 'type', 'type_entrie_id', 'enable_checkbook', 'enable_headline', 'enable_date_constraint']);

        if ($request->ajax()) {
            try {
                $typeBankTransaction->update($type_details);
                $output = [
                    'success' => true,
                    'msg' => __('accounting.updated_successfully'),
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TypeBankTransaction  $typeBankTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $typeBankTransaction = TypeBankTransaction::findOrFail($id);
        if (request()->ajax()) {
            try {
                $bankTransactions = BankTransaction::where('type_bank_transaction_id', $typeBankTransaction->id)->count();

                if ($bankTransactions > 0) {
                    $output = [
                        'success' => false,
                        'msg' => __('accounting.type_has_transactions'),
                    ];
                } else {
                    $typeBankTransaction->forceDelete();
                    $output = [
                        'success' => true,
                        'msg' => __('accounting.deleted_successfully'),
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

    public function getTypeBankTransactions(): JsonResponse
    {
        $types = TypeBankTransaction::select('id', 'name')->get();

        return response()->json($types);
    }

    public function getTypeBankTransactionsData()
    {
        $types = DB::table('type_bank_transactions as type')
            ->join('type_entries as entrie', 'entrie.id', '=', 'type.type_entrie_id')
            ->select('type.*', 'entrie.name as entrie_type');

        return DataTables::of($types)->toJson();
    }

    /**
     * Get bank transactions type enabled checkbook
     *
     * @return int
     */
    public function getIfEnableCheckbook(int $bank_transaction_type_id)
    {
        if (! empty($bank_transaction_type_id)) {
            $bank_transaction_type = TypeBankTransaction::find($bank_transaction_type_id);

            if (! empty($bank_transaction_type)) {
                return $bank_transaction_type->enable_checkbook;

            } else {
                return 0;
            }

        } else {
            return 0;
        }
    }
}
