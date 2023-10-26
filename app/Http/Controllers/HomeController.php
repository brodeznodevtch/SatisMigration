<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\BusinessLocation;
use App\Models\Currency;
use App\Models\Image;
use App\Models\PurchaseLine;
use App\Models\Transaction;
use App\Models\User;
use App\Models\VariationLocationDetails;
use App\Utils\BusinessUtil;
use App\Utils\ProductUtil;
use App\Utils\TransactionUtil;
use Carbon\Carbon;
use Charts;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * All Utils instance.
     */
    protected $businessUtil;

    protected $transactionUtil;

    protected $productUtil;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        BusinessUtil $businessUtil,
        TransactionUtil $transactionUtil,
        ProductUtil $productUtil
    ) {

        $this->businessUtil = $businessUtil;
        $this->transactionUtil = $transactionUtil;
        $this->productUtil = $productUtil;

        if (config('app.disable_sql_req_pk')) {
            DB::statement('SET SESSION sql_require_primary_key=0');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $business_id = request()->session()->get('user.business_id');
        if (! auth()->user()->can('dashboard.data')) {
            $images = Image::where('business_id', $business_id)
                ->whereRaw('DATE(end_date) >= ?', [date('Y-m-d')])
                ->orWhere('start_date', null)
                ->orWhere('end_date', null)
                ->where('is_active', true)
                ->get();

            return view('home.index', compact('images'));
        }

        $fy = $this->businessUtil->getCurrentFinancialYear($business_id);
        $date_filters['this_fy'] = $fy;
        $date_filters['this_month']['start'] = date('Y-m-01');
        $date_filters['this_month']['end'] = date('Y-m-t');
        $date_filters['this_week']['start'] = date('Y-m-d', strtotime('monday this week'));
        $date_filters['this_week']['end'] = date('Y-m-d', strtotime('sunday this week'));

        $currency = Currency::where('id', request()->session()->get('business.currency_id'))->first();

        $business = Business::find($business_id);

        // Dashboard settings
        if (empty($business->dashboard_settings)) {
            $dashboard_settings = $this->businessUtil->defaultDashboardSettings();
        } else {
            $dashboard_settings = json_decode($business->dashboard_settings, true);
        }

        // Sells last 30 days
        if (isset($dashboard_settings['sales_month']) && $dashboard_settings['sales_month'] == 1) {
            $sells_last_30_days = $this->transactionUtil->getSellsLast30Days($business_id);
            $sell_values = [];
        }

        // Purchases last 30 days
        if (isset($dashboard_settings['purchases_month']) && $dashboard_settings['purchases_month'] == 1) {
            $purchases_last_30_days = $this->transactionUtil->getPurchasesLast30Days($business_id);
            $purchase_values = [];
        }

        // Stock last 30 days
        if (isset($dashboard_settings['stock_month']) && $dashboard_settings['stock_month'] == 1) {
            $stock_last_30_days = $this->transactionUtil->getStockLast30Days($business_id);
            $stock_values = [];
        }

        for ($i = 29; $i >= 0; $i--) {
            $date = \Carbon::now()->subDays($i)->format('Y-m-d');

            $labels[] = date('j M Y', strtotime($date));

            if (isset($dashboard_settings['sales_month']) && $dashboard_settings['sales_month'] == 1) {
                if (! empty($sells_last_30_days[$date])) {
                    $sell_values[] = $sells_last_30_days[$date];
                } else {
                    $sell_values[] = 0;
                }
            }

            if (isset($dashboard_settings['purchases_month']) && $dashboard_settings['purchases_month'] == 1) {
                if (! empty($purchases_last_30_days[$date])) {
                    $purchase_values[] = $purchases_last_30_days[$date];
                } else {
                    $purchase_values[] = 0;
                }
            }

            if (isset($dashboard_settings['stock_month']) && $dashboard_settings['stock_month'] == 1) {
                if (! empty($stock_last_30_days[$date])) {
                    $stock_values[] = $stock_last_30_days[$date];
                } else {
                    $stock_values[] = 0;
                }
            }
        }

        $sells_chart_1 = null;

        // Chart sales last 30 days
        // $sells_chart_1 = null;
        // if (isset($dashboard_settings['sales_month']) && $dashboard_settings['sales_month'] == 1) {
        //     $sells_chart_1 = Charts::create('bar', 'highcharts')
        //         ->title(' ')
        //         ->template('material')
        //         ->values($sell_values)
        //         ->labels($labels)
        //         ->elementLabel(__('home.total_sells', ['currency' => $currency->code]))
        //         ->responsive(true);
        // }

        // // Chart purchases last 30 days
        // $purchases_chart_1 = null;
        // if (isset($dashboard_settings['purchases_month']) && $dashboard_settings['purchases_month'] == 1) {
        //     $purchases_chart_1 = Charts::create('bar', 'highcharts')
        //         ->title(' ')
        //         ->template('material')
        //         ->values($purchase_values)
        //         ->labels($labels)
        //         ->elementLabel(__('home.total_purchases', ['currency' => $currency->code]));
        // }

        // // Chart for stock last 30 days
        // $stocks_chart_1 = null;
        // if (isset($dashboard_settings['stock_month']) && $dashboard_settings['stock_month'] == 1) {
        //     $stocks_chart_1 = Charts::create('bar', 'highcharts')
        //         ->title(' ')
        //         ->template('material')
        //         ->values($stock_values)
        //         ->labels($labels)
        //         ->elementLabel(__('home.total_stocks', ['currency' => $currency->code]));
        // }

        // $labels = [];

        // // Chart for sells this financial year
        // if (isset($dashboard_settings['sales_year']) && $dashboard_settings['sales_year'] == 1) {
        //     $sells_this_fy = $this->transactionUtil->getSellsCurrentFy($business_id, $fy['start'], $fy['end']);
        //     $sell_values = [];
        // }

        // // Purchases current financial year
        // if (isset($dashboard_settings['purchases_year']) && $dashboard_settings['purchases_year'] == 1) {
        //     $purchases_this_fy = $this->transactionUtil->getPurchasesCurrentFy($business_id, $fy['start'], $fy['end']);
        //     $purchase_values = [];
        // }

        // // Stock current financial year
        // if (isset($dashboard_settings['stock_year']) && $dashboard_settings['stock_year'] == 1) {
        //     $stocks_this_fy = $this->transactionUtil->getStockCurrentFy($business_id, $fy['start']);
        //     $stock_values = [];
        // }

        // $months = [];
        // $date = strtotime($fy['start']);
        // $last = date('m-Y', strtotime($fy['end']));

        // do {
        //     $month_year = date('m-Y', $date);

        //     $month_number = date('m', $date);

        //     $labels[] = \Carbon::createFromFormat('m-Y', $month_year)
        //         ->format('M-Y');
        //     $date = strtotime('+1 month', $date);

        //     if (isset($dashboard_settings['sales_year']) && $dashboard_settings['sales_year'] == 1) {
        //         if (! empty($sells_this_fy[$month_year])) {
        //             $sell_values[] = $sells_this_fy[$month_year];
        //         } else {
        //             $sell_values[] = 0;
        //         }
        //     }

        //     if (isset($dashboard_settings['purchases_year']) && $dashboard_settings['purchases_year'] == 1) {
        //         if (! empty($purchases_this_fy[$month_year])) {
        //             $purchase_values[] = $purchases_this_fy[$month_year];
        //         } else {
        //             $purchase_values[] = 0;
        //         }
        //     }

        //     if (isset($dashboard_settings['stock_year']) && $dashboard_settings['stock_year'] == 1) {
        //         if (! empty($stocks_this_fy[$month_year])) {
        //             $stock_values[] = $stocks_this_fy[$month_year];
        //         } else {
        //             $stock_values[] = 0;
        //         }
        //     }
        // } while ($month_year != $last);

        // // Chart for sells this financial year
        // $sells_chart_2 = null;
        // if (isset($dashboard_settings['sales_year']) && $dashboard_settings['sales_year'] == 1) {
        //     $sells_chart_2 = Charts::create('bar', 'highcharts')
        //         ->title(__(' '))
        //         ->template('material')
        //         ->values($sell_values)
        //         ->labels($labels)
        //         ->elementLabel(__(
        //             'home.total_sells',
        //             ['currency' => $currency->code]
        //         ));
        // }

        // // Chart purchases current financial year
        // $purchases_chart_2 = null;
        // if (isset($dashboard_settings['purchases_year']) && $dashboard_settings['purchases_year'] == 1) {
        //     $purchases_chart_2 = Charts::create('bar', 'highcharts')
        //         ->title(__(' '))
        //         ->template('material')
        //         ->values($purchase_values)
        //         ->labels($labels)
        //         ->elementLabel(__(
        //             'home.total_purchases',
        //             ['currency' => $currency->code]
        //         ));
        // }

        // // Chart stock current financial year
        // $stocks_chart_2 = null;
        // if (isset($dashboard_settings['stock_year']) && $dashboard_settings['stock_year'] == 1) {
        //     $stocks_chart_2 = Charts::create('bar', 'highcharts')
        //         ->title(__(' '))
        //         ->template('material')
        //         ->values($stock_values)
        //         ->labels($labels)
        //         ->elementLabel(__(
        //             'home.total_stocks',
        //             ['currency' => $currency->code]
        //         ));
        // }

        $months = [
            '01' => __('accounting.january'),
            '02' => __('accounting.february'),
            '03' => __('accounting.march'),
            '04' => __('accounting.april'),
            '05' => __('accounting.may'),
            '06' => __('accounting.june'),
            '07' => __('accounting.july'),
            '08' => __('accounting.august'),
            '09' => __('accounting.september'),
            '10' => __('accounting.october'),
            '11' => __('accounting.november'),
            '12' => __('accounting.december'),
        ];

        $business_locations = BusinessLocation::where('business_id', $business_id)->get();

        // Locations
        $locations = BusinessLocation::forDropdown($business_id, false, false);

        $first_location = $locations->first();

        $default_location = null;

        // Access only to one locations
        if (count($locations) == 1) {
            foreach ($locations as $id => $name) {
                $default_location = $id;
                $first_location = $id;
            }

            // Access to all locations
        } elseif (auth()->user()->permitted_locations() == 'all') {
            $locations = $locations->prepend(__('kardex.all_2'), 'all');
            $first_location = 'all';
        } else {
            foreach ($locations as $id => $name) {
                $first_location = $id;
            }
        }

        $images = Image::where('business_id', $business_id)
            ->whereRaw('DATE(end_date) >= ?', [date('Y-m-d')])
            ->orWhere('start_date', null)
            ->orWhere('end_date', null)
            ->where('is_active', true)
            ->get();

        return view('home.index', compact(
            'date_filters',
            // 'sells_chart_1',
            // 'sells_chart_2',
            // 'purchases_chart_1',
            // 'purchases_chart_2',
            // 'stocks_chart_1',
            // 'stocks_chart_2',
            'months',
            'business_locations',
            'locations',
            'default_location',
            'first_location',
            'business',
            'dashboard_settings',
            'images'
        ));
    }

    /**
     * Get totals for dashboard cards according to selected month.
     *
     * @return array
     */
    public function chooseMonth()
    {
        try {
            $year = request()->get('year_modal');
            $month = request()->get('month_modal');

            $start = date($year.'-'.$month.'-01');
            $last_day = date('t', strtotime($start));
            $end = date($year.'-'.$month.'-'.$last_day);

            $output = [
                'success' => true,
                'start' => $start,
                'end' => $end,
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

    /**
     * Retrieves purchase details for a given time period.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPurchaseDetails()
    {
        if (request()->ajax()) {
            $start = request()->start;
            $end = request()->end;
            $location_id = request()->location_id;
            $business_id = request()->session()->get('user.business_id');

            $purchase_details = $this->transactionUtil->getPurchaseTotals($business_id, $start, $end, $location_id);

            return $purchase_details;
        }
    }

    /**
     * Retrieves sell details for a given time period.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSellDetails()
    {
        if (request()->ajax()) {
            $start = request()->start;
            $end = request()->end;
            $location_id = request()->location_id;
            $business_id = request()->session()->get('user.business_id');

            $sell_details = $this->transactionUtil->getSellTotals($business_id, $start, $end, $location_id);

            return $sell_details;
        }
    }

    /**
     * Retrieves sell products whose available quntity is less than alert quntity.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProductStockAlert()
    {
        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');

            $location_id = request()->location_id;

            $query = VariationLocationDetails::join(
                'product_variations as pv',
                'variation_location_details.product_variation_id',
                '=',
                'pv.id'
            )
                ->join(
                    'variations as v',
                    'variation_location_details.variation_id',
                    '=',
                    'v.id'
                )
                ->join(
                    'products as p',
                    'variation_location_details.product_id',
                    '=',
                    'p.id'
                )
                ->leftjoin(
                    'business_locations as l',
                    'variation_location_details.location_id',
                    '=',
                    'l.id'
                )
                ->leftjoin('units as u', 'p.unit_id', '=', 'u.id')
                ->where('p.business_id', $business_id)
                ->where('p.enable_stock', 1)
                ->whereRaw('variation_location_details.qty_available <= p.alert_quantity');

            //Check for permitted locations of a user
            $permitted_locations = auth()->user()->permitted_locations();
            if ($permitted_locations != 'all') {
                $query->whereIn('variation_location_details.location_id', $permitted_locations);
            }

            //Filter by the location
            if (! empty($location_id)) {
                $query->where('variation_location_details.location_id', $location_id);
            }

            $products = $query->count('p.id');

            return $products;

        }
    }

    /**
     * Retrieves payment dues for the purchases.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSalesPaymentDues()
    {
        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');
            $today = \Carbon::now()->format('Y-m-d H:i:s');

            $location_id = request()->location_id;

            $query = Transaction::join('customers as c', 'transactions.customer_id', 'c.id')
                ->join('payment_terms as pt', 'c.payment_terms_id', '=', 'pt.id')
                ->where('transactions.business_id', $business_id)
                ->where('transactions.type', 'sell')
                ->where('transactions.payment_status', '!=', 'paid')
                ->whereRaw("DATEDIFF('$today', DATE_ADD( transactions.transaction_date, INTERVAL pt.days DAY)) > 0");

            //Check for permitted locations of a user
            $permitted_locations = auth()->user()->permitted_locations();
            if ($permitted_locations != 'all') {
                $query->whereIn('transactions.location_id', $permitted_locations);
            }
            //Filter by the location
            if (! empty($location_id)) {
                $query->where('transactions.location_id', $location_id);
            }

            $dues = $query->count('transactions.id');

            return $dues;
        }
    }

    /**
     * Retrieves payment dues for the purchases.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPurchasePaymentDues()
    {
        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');
            $today = \Carbon::now()->format('Y-m-d H:i:s');

            $location_id = request()->location_id;

            $query = Transaction::join('contacts as c', 'transactions.contact_id', 'c.id')
                ->join('payment_terms as pt', 'c.payment_term_id', '=', 'pt.id')
                ->where('transactions.business_id', $business_id)
                ->where('transactions.type', 'purchase')
                ->where('transactions.payment_status', '!=', 'paid')
                ->whereRaw("DATEDIFF('$today', DATE_ADD( transactions.transaction_date, INTERVAL pt.days DAY)) > 0");

            //Check for permitted locations of a user
            $permitted_locations = auth()->user()->permitted_locations();
            if ($permitted_locations != 'all') {
                $query->whereIn('transactions.location_id', $permitted_locations);
            }
            //Filter by the location
            if (! empty($location_id)) {
                $query->where('transactions.location_id', $location_id);
            }

            $dues = $query->count('transactions.id');

            return $dues;
        }
    }

    /**
     * Shows amount of products close to expire and expired ones
     *
     * @return \Illuminate\Http\Response
     */
    public function getStockExpiryProducts(Request $request)
    {
        if (! auth()->user()->can('stock_expiry_report.view')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = $request->session()->get('user.business_id');

        $location_id = request()->location_id;

        //Return the details in ajax call
        if ($request->ajax()) {
            $query = PurchaseLine::leftjoin(
                'transactions as t',
                'purchase_lines.transaction_id',
                '=',
                't.id'
            )
                ->leftjoin(
                    'products as p',
                    'purchase_lines.product_id',
                    '=',
                    'p.id'
                )
                ->leftjoin(
                    'variations as v',
                    'purchase_lines.variation_id',
                    '=',
                    'v.id'
                )
                ->leftjoin(
                    'product_variations as pv',
                    'v.product_variation_id',
                    '=',
                    'pv.id'
                )
                ->leftjoin('business_locations as l', 't.location_id', '=', 'l.id')
                ->leftjoin('units as u', 'p.unit_id', '=', 'u.id')
                ->where('t.business_id', $business_id)
                ->whereNotNull('exp_date')
                ->where('p.enable_stock', 1)
                ->whereRaw('purchase_lines.quantity > purchase_lines.quantity_sold + quantity_adjusted + quantity_returned');

            $permitted_locations = auth()->user()->permitted_locations();

            if ($permitted_locations != 'all') {
                $query->whereIn('t.location_id', $permitted_locations);
            }

            //Filter by the location
            if (! empty($location_id)) {
                $query->where('t.location_id', $location_id);
            }

            $products = $query->count('p.id');

            return $products;
        }
    }

    /**
     * Get the monetary value of the total stock.
     *
     * @param  float  $request
     * @return \Illuminate\Http\Response
     */
    public function getTotalStock(Request $request)
    {
        // Params
        $business_id = $request->session()->get('user.business_id');
        $location_id = request()->location_id;
        $date = request()->end;

        // Get data
        $result = DB::select(
            'SELECT monetary_total_stock(?, ?, ?) AS result',
            [$business_id, $location_id, $date]
        );

        return $result[0]->result;
    }

    /**
     * Get peak sales hours by month chart.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPeakSalesHoursByMonthChart()
    {
        $business_id = request()->session()->get('user.business_id');

        $date_initial = \Carbon::now()->subDays(30);
        $date_final = \Carbon::now();

        $location = request()->get('location_month');

        // Peak sales hours
        $sales = $this->transactionUtil->getPeakSalesHours($business_id, $location, $date_initial, $date_final);

        $labels = [];
        $values = [];

        foreach ($sales as $hour => $sale) {
            $labels[] = $this->transactionUtil->format_time($hour.':00:00');
            $values[] = $sale;
        }

        $sells_chart_4 = Charts::create('bar', 'highcharts')
            ->title(' ')
            ->template('material')
            ->values($values)
            ->labels($labels)
            ->elementLabel(__('accounting.total_sales'));

        return view('home.peak_sales_hours_month_chart', compact('sells_chart_4'));
    }

    /**
     * Get peak sales hours chart.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPeakSalesHoursChart()
    {
        $business_id = request()->session()->get('user.business_id');

        $fiscal_year = $this->businessUtil->getCurrentFinancialYear($business_id);

        $location = request()->get('location');

        // Peak sales hours
        $sales = $this->transactionUtil->getPeakSalesHours($business_id, $location, $fiscal_year['start'], $fiscal_year['end']);

        $labels = [];
        $values = [];

        foreach ($sales as $hour => $sale) {
            $labels[] = $this->transactionUtil->format_time($hour.':00:00');
            $values[] = $sale;
        }

        $sells_chart_3 = Charts::create('bar', 'highcharts')
            ->title(' ')
            ->template('material')
            ->values($values)
            ->labels($labels)
            ->elementLabel(__('accounting.total_sales'));

        return view('home.peak_sales_hours_chart', compact('sells_chart_3'));
    }

    public function getProfitsDetails()
    {
        if (request()->ajax()) {
            $start = request()->start;
            $end = request()->end;
            $location_id = request()->location_id;
            $business_id = request()->session()->get('user.business_id');

            $sale_details = $this->transactionUtil->getSellTotals($business_id, $start, $end, $location_id);
            $purchase_details = $this->transactionUtil->getPurchaseTotals($business_id, $start, $end, $location_id);
            $expense_details = $this->transactionUtil->getExpenseTotals($business_id, $start, $end, $location_id);

            $business = Business::find($business_id);
            $dashboard_settings = empty($business->dashboard_settings) ? null : json_decode($business->dashboard_settings, true);
            $details['box_exc_tax'] = is_null($dashboard_settings) ? 0 : $dashboard_settings['box_exc_tax'];

            if ($details['box_exc_tax']) {
                $details = [
                    'gross_profit' => $sale_details['total_sell_exc_tax'] - $purchase_details['total_purchase_exc_tax'],
                    'net_earnings' => ($sale_details['total_sell_exc_tax'] - $purchase_details['total_purchase_exc_tax']) - $expense_details['total_expense_exc_tax'],
                    'total_expense' => $expense_details['total_expense_exc_tax'],
                ];
            } else {
                $details = [
                    'gross_profit' => $sale_details['total_sell_inc_tax'] - $purchase_details['total_purchase_inc_tax'],
                    'net_earnings' => ($sale_details['total_sell_inc_tax'] - $purchase_details['total_purchase_inc_tax']) - $expense_details['total_expense_inc_tax'],
                    'total_expense' => $expense_details['total_expense_inc_tax'],
                ];
            }

            return $details;
        }
    }

    public function getListTrendingProducts()
    {
        if (request()->ajax()) {
            // $start = request()->start;
            // $end = request()->end;
            $business_id = request()->session()->get('user.business_id');
            // if(!empty($end) && !empty($start)){
            //     $filters['start_date'] = $start;
            //     $filters['end_date'] = $end;
            // }
            $filters['limit'] = 5;

            $products = $this->productUtil->getTrendingProducts($business_id, $filters);
            foreach ($products as $product) {
                $product->product = $product->product;
                $product->total_unit_sold = round($product->total_unit_sold, 2);
                $product->total_sells = $this->productUtil->num_f($product->total_sells, true, 2);
                $product->last_sells = $this->productUtil->num_f($product->last_sells, true, 2);
            }

            return $products;
        }
    }

    public function getWeekSales()
    {
        if (request()->ajax()) {
            $location_id = request()->location_id;
            $business_id = request()->session()->get('user.business_id');
            $currency = Currency::where('id', request()->session()->get('business.currency_id'))->first();

            $today = Carbon::now(); //Sells previous week and current week
            $startOfThisWeek = $today->startOfWeek(); // Get start of this week
            $endOfThisWeek = $today->copy()->endOfWeek(); // Get end of this week
            $startOfLastWeek = $startOfThisWeek->copy()->subWeek(); // Get start of last week
            $endOfLastWeek = $startOfLastWeek->copy()->addDays(6); // Get end of last week

            $sells_previous_week = $this->transactionUtil->getSellsByWeek($business_id, $startOfLastWeek, $endOfLastWeek, $location_id);
            $sells_current_week = $this->transactionUtil->getSellsByWeek($business_id, $startOfThisWeek, $endOfThisWeek, $location_id);
            $sell_values_previous_week = [];
            $sell_values_current_week = [];

            $sells_chart_line_1 = null;
            $labels = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
            if (! empty($sells_previous_week) || ! empty($sells_current_week)) {
                for ($i = 2; $i <= 7; $i++) {
                    if (isset($sells_previous_week[$i])) {
                        $sell_values_previous_week[] = $this->transactionUtil->num_f($sells_previous_week[$i]);
                    } else {
                        $sell_values_previous_week[] = $this->transactionUtil->num_f(0);
                    }

                    if (isset($sells_current_week[$i])) {
                        $sell_values_current_week[] = $this->transactionUtil->num_f($sells_current_week[$i]);
                    } else {
                        $sell_values_current_week[] = $this->transactionUtil->num_f(0);
                    }
                }
                if (isset($sells_previous_week[1])) {
                    $sell_values_previous_week[6] = $this->transactionUtil->num_f($sells_previous_week[1]);
                } else {
                    $sell_values_previous_week[6] = $this->transactionUtil->num_f(0);
                }

                if (isset($sells_current_week[1])) {
                    $sell_values_current_week[6] = $this->transactionUtil->num_f($sells_current_week[1]);
                } else {
                    $sell_values_current_week[6] = $this->transactionUtil->num_f(0);
                }
            }

            return response()->json(['labels' => $labels, 'sell_values_previous_week' => $sell_values_previous_week, 'sell_values_current_week' => $sell_values_current_week]);
        }
    }

    public function welcome()
    {
        return view('welcome');
    }
}
