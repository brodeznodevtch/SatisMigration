<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Models\Country;
use App\Models\State;
use App\Models\Zone;
use DataTables;
use Illuminate\Http\Request;
use Storage;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $business_id = request()->session()->get('user.business_id');

        $countries = Country::select('id', 'name', 'flag')->where('business_id', $business_id)->get();
        $zones = Zone::select('id', 'name')->where('business_id', $business_id)->get();
        $states = State::select('id', 'name')->where('business_id', $business_id)->get();

        return view('geography.index', compact('countries', 'zones', 'states'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('geography.index');
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
                'name' => 'required|unique:countries',
            ]
        );
        if ($request->ajax()) {
            try {

                $country_details = $request->only(['name', 'short_name', 'code']);
                $country_details['business_id'] = request()->session()->get('user.business_id');

                if ($request->hasFile('flag')) {
                    $file = $request->file('flag');
                    $name = time().$file->getClientOriginalName();
                    Storage::disk('flags')->put($name, \File::get($file));
                    $country_details['flag'] = $name;
                }

                $country = Country::create($country_details);
                $output = [
                    'success' => true,
                    'msg' => __('geography.country_added'),
                ];

            } catch (\Exception $e) {
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
     * @param  \App\Models\Country  $country
     */
    public function show($id): JsonResponse
    {
        $country = Country::findOrFail($id);

        return response()->json($country);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $country
     */
    public function edit($id): JsonResponse
    {
        $country = Country::findOrFail($id);

        return response()->json($country);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Country  $country
     */
    public function update(Request $request, $id): View
    {
        return view('geography.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (request()->ajax()) {
            $country = Country::findOrFail($id);
            try {

                $states = State::where('country_id', $country->id)->count();

                if ($states > 0) {
                    $output = [
                        'success' => false,
                        'msg' => __('geography.country_has_states'),
                    ];
                } else {
                    $country->forceDelete();
                    $output = [
                        'success' => true,
                        'msg' => __('geography.country_deleted'),
                    ];
                }
            } catch (\Exception $e) {
                \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());
                $output = [
                    'success' => false,
                    'msg' => __('messages.something_went_wrong'),
                ];
            }

            return $output;
        }
    }

    public function getCountriesData()
    {
        $business_id = request()->session()->get('user.business_id');
        $countries = Country::where('business_id', $business_id);

        return DataTables::of($countries)
            ->addColumn('img', function ($row) {
                return '<img src="'.asset('flags/'.$row->flag).'" width="50" height="25">';
            })
            ->rawColumns(['img'])
            ->toJson();
    }

    public function getCountries(): JsonResponse
    {
        $business_id = request()->session()->get('user.business_id');
        $countries = Country::where('business_id', $business_id)->get();

        return response()->json($countries);
    }

    public function updateCountry(Request $request)
    {
        $country = Country::findOrFail($request->input('country_id'));

        $validateData = $request->validate(
            [
                'ename' => 'required|unique:countries,name,'.$country->id,
            ]
        );
        if ($request->ajax()) {
            try {

                $country->name = $request->input('ename');
                $country->short_name = $request->input('eshort_name');
                $country->code = $request->input('ecode');

                if ($request->hasFile('eflag')) {
                    $file = $request->file('eflag');
                    $name = time().$file->getClientOriginalName();
                    Storage::disk('flags')->put($name, \File::get($file));
                    $country->flag = $name;
                }
                $country->save();

                $output = [
                    'success' => true,
                    'msg' => __('geography.country_updated'),
                ];

            } catch (\Exception $e) {
                \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());
                $output = [
                    'success' => false,
                    'msg' => __('messages.something_went_wrong'),
                ];
            }

            return $output;
        }
    }
}
