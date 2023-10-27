<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Brands;
use App\Models\BusinessLocation;
use App\Models\FixedAsset;
use App\Models\FixedAssetType;
use App\Utils\TransactionUtil;
use DataTables;
use Illuminate\Http\Request;

class FixedAssetController extends Controller
{
    /**
     * All Utils instance
     */
    private $transactionUtil;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct(TransactionUtil $transactionUtil)
    {
        $this->transactionUtil = $transactionUtil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! auth()->user()->can('fixed_asset.view')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->user()->business_id;

        if (request()->ajax()) {
            $fixed_asset = FixedAsset::join('fixed_asset_types as fat', 'fixed_assets.fixed_asset_type_id', 'fat.id')
                ->leftJoin('business_locations as bl', 'fixed_assets.location_id', 'bl.id')
                ->leftJoin('brands as b', 'fixed_assets.brand_id', 'b.id')
                ->where('fixed_assets.business_id', $business_id)
                ->select(
                    'fixed_assets.id',
                    'fixed_assets.code',
                    'fixed_assets.name',
                    'fixed_assets.type',
                    'bl.name as location_name',
                    'fixed_assets.initial_value',
                    'fixed_assets.current_value'
                );

            return DataTables::of($fixed_asset)
                ->addColumn('action', function ($row) {
                    $action = '';
                    if (auth()->user()->can('fixed_asset.edit')) {
                        $action .= "<a class='btn btn-primary btn-xs edit_fixed_asset' href=".action([\App\Http\Controllers\FixedAssetController::class, 'edit'], [$row->id])."><i class='glyphicon glyphicon-edit'></i></a>";
                    }
                    if (auth()->user()->can('fixed_asset.delete')) {
                        $action .= "&nbsp;<a class='btn btn-danger btn-xs delete_fixed_asset' href=".action([\App\Http\Controllers\FixedAssetController::class, 'destroy'], [$row->id])."><i class='glyphicon glyphicon-trash'></i></a>";
                    }

                    return $action;
                })->removeColumn('id')
                ->editColumn('initial_value', '<span class="display_currency" data-currency_symbol="true" ">{{ $initial_value }}</span>')
                ->editColumn('current_value', '<span class="display_currency" data-currency_symbol="true" ">{{ $current_value }}</span>')
                ->editColumn('type', '{{ __("fixed_asset.". $type) }}')
                ->rawColumns(['action', 'type', 'initial_value', 'current_value'])
                ->make(true);
        }

        return view('fixed_asset.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        if (! auth()->user()->can('fixed_asset.create')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->user()->business_id;

        $last_id = FixedAsset::withTrashed()->where('business_id', $business_id)->count();
        $fixed_asset_code = $this->transactionUtil->generateFixedAssetPrefix($business_id, $last_id);

        $fixed_asset_types = FixedAssetType::forDropdown($business_id);
        $locations = BusinessLocation::forDropdown($business_id);
        $brands = Brands::brandsDropdown($business_id, false, false);

        return view('fixed_asset.create', compact('fixed_asset_code', 'fixed_asset_types', 'locations', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! auth()->user()->can('fixed_asset.create')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $input = $request->except('_token');
            $input['business_id'] = $request->user()->business_id;

            FixedAsset::create($input);

            $output = ['success' => true, 'msg' => __('fixed_asset.fixed_asset_added_success')];

        } catch (\Exception $e) {
            \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

            $output = ['success' => false, 'msg' => __('messages.something_went_wrong')];
        }

        return $output;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        if (! auth()->user()->can('fixed_asset.edit')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->user()->business_id;

        $fixed_asset = FixedAsset::find($id);

        $fixed_asset_types = FixedAssetType::forDropdown($business_id);
        $locations = BusinessLocation::forDropdown($business_id);
        $brands = Brands::brandsDropdown($business_id, false, false);

        return view('fixed_asset.edit', compact('fixed_asset', 'fixed_asset_types', 'locations', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        if (! auth()->user()->can('fixed_asset.edit')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $fixed_asset = FixedAsset::find($id);
            $input = $request->except('_token');

            $fixed_asset->update($input);

            $output = ['success' => true, 'msg' => __('fixed_asset.fixed_asset_updated_success')];

        } catch (\Exception $e) {
            \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

            $output = ['success' => false, 'msg' => __('messages.something_went_wrong')];
        }

        return $output;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (! auth()->user()->can('fixed_asset.delete')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $fixed_asset_type = FixedAsset::find($id);

            $fixed_asset_type->delete();
            $output = ['success' => true, 'msg' => __('fixed_asset.fixed_asset_deleted_success')];

        } catch (\Exception $e) {
            \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

            $output = ['success' => false, 'msg' => __('messages.something_went_wrong')];
        }

        return $output;
    }
}
