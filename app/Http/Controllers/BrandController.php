<?php

namespace App\Http\Controllers;

use App\Models\Brands;
use App\Utils\ProductUtil;
use DB;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{
    /**
     * All Utils instance.
     */
    protected $productUtil;

    private $clone_product;

    /**
     * Constructor
     *
     * @param  ProductUtil  $product
     * @return void
     */
    public function __construct(ProductUtil $productUtil)
    {
        $this->productUtil = $productUtil;

        /** clone product config */
        $this->clone_product = config('app.clone_product');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! auth()->user()->can('brand.view') && ! auth()->user()->can('brand.create')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');

            $brands = Brands::where('business_id', $business_id)
                ->select(['name', 'description', 'id']);

            return Datatables::of($brands)
                ->addColumn(
                    'action',
                    '@can("brand.update")
                    <button data-href="{{action(\'BrandController@edit\', [$id])}}" class="btn btn-xs btn-primary edit_brand_button"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")</button>
                        &nbsp;
                    @endcan
                    @can("brand.delete")
                        <button data-href="{{action(\'BrandController@destroy\', [$id])}}" class="btn btn-xs btn-danger delete_brand_button"><i class="glyphicon glyphicon-trash"></i> @lang("messages.delete")</button>
                    @endcan'
                )
                ->removeColumn('id')
                ->rawColumns([2])
                ->make(false);
        }

        return view('brand.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        if (! auth()->user()->can('brand.create')) {
            abort(403, 'Unauthorized action.');
        }

        $quick_add = false;
        if (! empty(request()->input('quick_add'))) {
            $quick_add = true;
        }

        return view('brand.create')
            ->with(compact('quick_add'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! auth()->user()->can('brand.create')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $input = $request->only(['name', 'description']);
            $business_id = $request->session()->get('user.business_id');
            $input['business_id'] = $business_id;
            $input['created_by'] = $request->session()->get('user.id');

            DB::beginTransaction();

            // Upload logo
            $input['logo'] = $this->productUtil->uploadFile($request, 'logo', config('constants.product_img_path'));

            $brand = Brands::create($input);

            /** sync brand */
            if ($this->clone_product) {
                $this->productUtil->syncBrand($brand->id, $brand->name);
            }

            DB::commit();

            $output = ['success' => true,
                'data' => $brand,
                'msg' => __('brand.added_success'),
            ];
        } catch (\Exception $e) {
            DB::rollback();
            \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

            $output = ['success' => false,
                'msg' => __('messages.something_went_wrong'),
            ];
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
        if (! auth()->user()->can('brand.update')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');
            $brand = Brands::where('business_id', $business_id)->find($id);

            return view('brand.edit')
                ->with(compact('brand'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        if (! auth()->user()->can('brand.update')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $input = $request->only(['name', 'description']);
                $business_id = $request->session()->get('user.business_id');

                DB::beginTransaction();

                $brand = Brands::where('business_id', $business_id)->findOrFail($id);
                $name = $brand->name;

                $brand->name = $input['name'];
                $brand->description = $input['description'];

                // Upload logo
                $file_name = $this->productUtil->uploadFile($request, 'logo', config('constants.product_img_path'));

                if (! empty($file_name)) {
                    $brand->logo = $file_name;
                }

                $brand->save();

                /** sync brand */
                if ($this->clone_product) {
                    $this->productUtil->syncBrand($brand->id, $name);
                }

                DB::commit();

                $output = [
                    'success' => true,
                    'msg' => __('brand.updated_success'),
                ];

            } catch (\Exception $e) {
                DB::rollback();
                \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

                $output = ['success' => false,
                    'msg' => __('messages.something_went_wrong'),
                ];
            }

            return $output;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        if (! auth()->user()->can('brand.delete')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $business_id = request()->user()->business_id;

                DB::beginTransaction();

                $brand = Brands::where('business_id', $business_id)->findOrFail($id);
                $old_brand = clone $brand;
                $brand->delete();

                /** sync brand */
                if ($this->clone_product) {
                    $this->productUtil->syncBrand($brand->id, '', $old_brand);
                }

                DB::commit();

                $output = [
                    'success' => true,
                    'msg' => __('brand.deleted_success'),

                ];

            } catch (\Exception $e) {
                DB::rollback();
                \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

                $output = ['success' => false,
                    'msg' => __('messages.something_went_wrong'),
                ];
            }

            return $output;
        }
    }
}
