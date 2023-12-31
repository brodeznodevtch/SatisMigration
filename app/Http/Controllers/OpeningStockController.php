<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\Transaction;
use App\BusinessLocation;
use App\MovementType;
use App\PurchaseLine;

use App\Utils\ProductUtil;
use App\Utils\TransactionUtil;
use App\Warehouse;

use Illuminate\Support\Facades\DB;

class OpeningStockController extends Controller
{

    /**
     * All Utils instance.
     *
     */
    protected $productUtil;
    protected $transactionUtil;

    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(ProductUtil $productUtil, TransactionUtil $transactionUtil)
    {
        $this->productUtil = $productUtil;
        $this->transactionUtil = $transactionUtil;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function add($product_id)
    {
        if (!auth()->user()->can('product.update')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');

        //Get the product
        $product = Product::where('business_id', $business_id)
                            ->where('id', $product_id)
                            ->with(['variations', 'variations.product_variation', 'unit'])
                            ->first();
        if (!empty($product)) {
            //Get Opening Stock Transactions for the product if exists
            $transactions = Transaction::where('business_id', $business_id)
                                ->where('opening_stock_product_id', $product_id)
                                ->where('type', 'opening_stock')
                                ->with(['purchase_lines'])
                                ->get();
            
            $purchases = [];
            foreach ($transactions as $transaction) {
                $purchase_lines = [];

                foreach ($transaction->purchase_lines as $purchase_line) {
                    if (!empty($purchase_lines[$purchase_line->variation_id])) {
                        $k = count($purchase_lines[$purchase_line->variation_id]);
                    } else {
                        $k = 0;
                        $purchase_lines[$purchase_line->variation_id] = [];
                    }

                    $purchase_lines[$purchase_line->variation_id][$k]['quantity'] = $purchase_line->quantity;
                    $purchase_lines[$purchase_line->variation_id][$k]['purchase_price'] = $purchase_line->purchase_price;
                    $purchase_lines[$purchase_line->variation_id][$k]['purchase_line_id'] = $purchase_line->id;
                    $purchase_lines[$purchase_line->variation_id][$k]['exp_date'] = $purchase_line->exp_date;
                    $purchase_lines[$purchase_line->variation_id][$k]['lot_number'] = $purchase_line->lot_number;
                }

                // Changes from locations to warehouses
                $purchases[$transaction->warehouse_id] = $purchase_lines;
            }

            // Changes from locations to warehouses
            // $locations = BusinessLocation::forDropdown($business_id);
            $locations = Warehouse::forDropdown($business_id, false);

            $enable_expiry = request()->session()->get('business.enable_product_expiry');
            $enable_lot = request()->session()->get('business.enable_lot_number');

            if (request()->ajax()) {
                return view('opening_stock.ajax_add')
                    ->with(compact(
                        'product',
                        'locations',
                        'purchases',
                        'enable_expiry',
                        'enable_lot'
                    ));
            }

            return view('opening_stock.add')
                    ->with(compact(
                        'product',
                        'locations',
                        'purchases',
                        'enable_expiry',
                        'enable_lot'
                    ));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        //dd($request);
        if (!auth()->user()->can('product.update')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $opening_stocks = $request->input('stocks');
            $product_id = $request->input('product_id');

            $business_id = $request->session()->get('user.business_id');
            $user_id = $request->session()->get('user.id');

            $product = Product::where('business_id', $business_id)
                ->where('id', $product_id)
                ->with(['variations', 'product_tax'])
                ->first();

            // Changes from locations to warehouses
            //$locations = BusinessLocation::forDropdown($business_id)->toArray();
            $locations = Warehouse::forDropdown($business_id, false)->toArray();

            if (!empty($product)) {
                //Get product tax
                $tax_percent = !empty($product->product_tax->amount) ? $product->product_tax->amount : 0;
                $tax_id = !empty($product->product_tax->id) ? $product->product_tax->id : null;

                //Get start date for financial year.
                $transaction_date = request()->session()->get("financial_year.start");
                $transaction_date = \Carbon::createFromFormat('Y-m-d', $transaction_date)->toDateTimeString();

                DB::beginTransaction();
                //$key is the warehouse_id
                foreach ($opening_stocks as $key => $value) {
                    $warehouse_id = $key;
                    $purchase_total = 0;

                    // Gets location from the warehouse
                    $warehouse_aux = Warehouse::find($warehouse_id);
                    $location_id = $warehouse_aux->business_location_id;

                    //Check if valid location
                    if (array_key_exists($warehouse_id, $locations)) {
                        $purchase_lines = [];
                        $updated_purchase_line_ids = [];

                        //create purchase_lines array
                        //$k is the variation id
                        foreach ($value as $k => $rows) {
                            foreach ($rows as $key => $v) {
                                $purchase_price = $this->productUtil->num_uf(trim($v['purchase_price']));
                                $item_tax = $this->productUtil->calc_percentage($purchase_price, $tax_percent);
                                $purchase_price_inc_tax = $purchase_price + $item_tax;
                                $qty = $this->productUtil->num_uf(trim($v['quantity']));

                                $exp_date = null;
                                if (!empty($v['exp_date'])) {
                                    $exp_date = \Carbon::createFromFormat('d-m-Y', $v['exp_date'])->format('Y-m-d');
                                }

                                $lot_number = null;
                                if (!empty($v['lot_number'])) {
                                    $lot_number = $v['lot_number'];
                                }

                                if ($qty > 0) {
                                    $qty_formated = $this->productUtil->num_f($qty);
                                    //Calculate transaction total
                                    $purchase_total += ($purchase_price_inc_tax * $qty);
                                    if (isset($v['purchase_line_id'])) {
                                        $purchase_line = PurchaseLine::findOrFail($v['purchase_line_id']);
                                        $updated_purchase_line_ids[] = $purchase_line->id;

                                        $old_qty = $this->productUtil->num_f($purchase_line->quantity);

                                        $this->productUtil->updateProductQuantity($location_id, $product->id, $k, $qty_formated, $old_qty, null, $warehouse_id);
                                    } else {
                                        //create newly added purchase lines
                                        $purchase_line = new PurchaseLine();
                                        $purchase_line->product_id = $product->id;
                                        $purchase_line->variation_id = $k;

                                        $this->productUtil->updateProductQuantity($location_id, $product->id, $k, $qty_formated, 0, null, $warehouse_id);
                                    }
                                    $purchase_line->item_tax = $item_tax;
                                    $purchase_line->tax_id = $tax_id;
                                    $purchase_line->quantity = $qty;
                                    $purchase_line->pp_without_discount = $purchase_price;
                                    $purchase_line->purchase_price = $purchase_price;
                                    $purchase_line->purchase_price_inc_tax = $purchase_price_inc_tax;
                                    $purchase_line->exp_date = $exp_date;
                                    $purchase_line->lot_number = $lot_number;
                                    $purchase_lines[] = $purchase_line;
                                }
                            }
                        }

                        $delete_variation_ids = [];
                        $transaction = [];
                        //create transaction & purchase lines
                        if (!empty($purchase_lines)) {
                            $is_new_transaction = false;

                            $transaction = Transaction::where('type', 'opening_stock')
                                ->where('business_id', $business_id)
                                ->where('opening_stock_product_id', $product->id)
                                ->where('location_id', $location_id)
                                ->where('warehouse_id', $warehouse_id)
                                ->first();
                            if (!empty($transaction)) {
                                $transaction->total_before_tax = $purchase_total;
                                $transaction->final_total = $purchase_total;
                                $transaction->update();
                            } else {
                                $is_new_transaction = true;

                                $transaction = Transaction::create(
                                    [
                                        'type' => 'opening_stock',
                                        'opening_stock_product_id' => $product->id,
                                        'status' => 'received',
                                        'business_id' => $business_id,
                                        'transaction_date' => $transaction_date,
                                        'total_before_tax' => $purchase_total,
                                        'location_id' => $location_id,
                                        'final_total' => $purchase_total,
                                        'payment_status' => 'paid',
                                        'created_by' => $user_id,
                                        'warehouse_id' => $warehouse_id
                                    ]
                                );
                            }

                            # Data to create or update kardex lines
                            $lines_before = PurchaseLine::where('transaction_id', $transaction->id)->get();

                            //unset deleted purchase lines
                            $delete_purchase_line_ids = [];
                            $delete_purchase_lines = null;
                            if (!empty($updated_purchase_line_ids)) {
                                $delete_purchase_lines = PurchaseLine::where('transaction_id', $transaction->id)
                                    ->whereNotIn('id', $updated_purchase_line_ids)
                                    ->get();

                                if ($delete_purchase_lines->count()) {
                                    foreach ($delete_purchase_lines as $delete_purchase_line) {
                                        $delete_purchase_line_ids[] = $delete_purchase_line->id;
                                        $delete_variation_ids[] = $delete_purchase_line->variation_id;

                                        //decrease deleted only if previous status was received
                                        $this->productUtil->decreaseProductQuantity(
                                            $delete_purchase_line->product_id,
                                            $delete_purchase_line->variation_id,
                                            $transaction->location_id,
                                            $delete_purchase_line->quantity,
                                            0,
                                            $transaction->warehouse_id
                                        );
                                    }
                                    //Delete deleted purchase lines
                                    PurchaseLine::where('transaction_id', $transaction->id)
                                                ->whereIn('id', $delete_purchase_line_ids)
                                                ->delete();
                                }
                            }
                            $transaction->purchase_lines()->saveMany($purchase_lines);

                            # Data to create or update kardex lines
                            $lines = PurchaseLine::where('transaction_id', $transaction->id)->get();

                            $movement_type = MovementType::where('name', 'opening_stock')
                                ->where('type', 'input')
                                ->where('business_id', $business_id)
                                ->first();

                            # Check if movement type is set else create it
                            if (empty($movement_type)) {
                                $movement_type = MovementType::create([
                                    'name' => 'opening_stock',
                                    'type' => 'input',
                                    'business_id' => $business_id
                                ]);
                            }

                            # Store kardex
                            $this->transactionUtil->createOrUpdateInputLines($movement_type, $transaction, 'OS' . $transaction->id, $lines, $lines_before);

                            //Update mapping of purchase & Sell.
                            if (!$is_new_transaction) {
                                $this->transactionUtil->adjustMappingPurchaseSellAfterEditingPurchase('received', $transaction, $delete_purchase_lines);
                            }



                            //************************************************************** */
                            //************************************************************** */
                            //************************************************************** */
                            //************************************************************** */
                            // Edit avarage cost
                            $enable_editing_avg_cost = $request->session()->get('business.enable_editing_avg_cost_from_purchase');

                            if ($enable_editing_avg_cost == 1) {
                                $variation_ids = PurchaseLine::where('transaction_id', $transaction->id)->pluck('variation_id');
                
                                foreach ($variation_ids as $variation_id) {
                                    $this->productUtil->recalculateProductCost($variation_id);
                                }

                                if (! empty($delete_variation_ids)) {
                                    foreach ($delete_variation_ids as $variation_id) {
                                        $this->productUtil->recalculateProductCost($variation_id);
                                    }
                                }
                            }
                            //************************************************************** */
                            //************************************************************** */
                            //************************************************************** */
                        } else {
                            //Delete transaction if all purchase line quantity is 0 (Only if transaction exists)
                            $delete_transaction = Transaction::where('type', 'opening_stock')
                                ->where('business_id', $business_id)
                                ->where('opening_stock_product_id', $product->id)
                                ->where('location_id', $location_id)
                                ->where('warehouse_id', $warehouse_id)
                                ->with(['purchase_lines'])
                                ->first();
                            
                            if (!empty($delete_transaction)) {
                                $delete_purchase_lines = $delete_transaction->purchase_lines;

                                foreach ($delete_purchase_lines as $delete_purchase_line) {
                                    $delete_variation_ids[] = $delete_purchase_line->variation_id;

                                    $this->productUtil->decreaseProductQuantity($product->id, $delete_purchase_line->variation_id, $location_id, $delete_purchase_line->quantity, 0, $warehouse_id);
                                    $delete_purchase_line->delete();
                                }

                                //Update mapping of purchase & Sell.
                                $this->transactionUtil->adjustMappingPurchaseSellAfterEditingPurchase('received', $delete_transaction, $delete_purchase_lines);

                                $delete_transaction->delete();
                            }
                        }
                    }
                }

                DB::commit();
            }

            $output = ['success' => 1,
                             'msg' => __('lang_v1.opening_stock_added_successfully')
                        ];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => 0,
                'msg' => $e->getMessage()
            ];
            return back()->with('status', $output);
        }

        if (request()->ajax()) {
                return $output;
        }

        return redirect('products')->with('status', $output);
    }
}
