<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Models\City;
use App\Models\State;
use DataTables;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('geography.index');
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
                'name' => 'required|unique:states',
                'country_id' => 'required',
                'zone_id' => 'required',
            ]
        );
        if ($request->ajax()) {
            try {

                $state_details = $request->only(['name', 'zip_code', 'country_id', 'zone_id']);
                $state_details['business_id'] = request()->session()->get('user.business_id');

                $state = State::create($state_details);
                $output = [
                    'success' => true,
                    'msg' => __('geography.state_added'),
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
     * @param  \App\Models\State  $state
     */
    public function show($id): JsonResponse
    {
        $state = State::findOrFail($id);

        return response()->json($state);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\State  $state
     */
    public function edit($id): JsonResponse
    {
        $state = State::findOrFail($id);

        return response()->json($state);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $state = State::findOrFail($id);

        $validateData = $request->validate(
            [
                'name' => 'required|unique:states,name,'.$state->id,
                'country_id' => 'required',
                'zone_id' => 'required',
            ]
        );
        if ($request->ajax()) {
            try {

                $state->name = $request->input('name');
                $state->zip_code = $request->input('zip_code');
                $state->country_id = $request->input('country_id');
                $state->zone_id = $request->input('zone_id');
                $state->save();

                $output = [
                    'success' => true,
                    'msg' => __('geography.state_updated'),
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (request()->ajax()) {
            try {

                $state = State::findOrFail($id);
                $cities = City::where('state_id', $state->id)->count();

                if ($cities > 0) {
                    $output = [
                        'success' => false,
                        'msg' => __('geography.state_has_cities'),
                    ];
                }

                $employees = DB::table('employees')
                    ->where('state_id', $id)
                    ->count();

                if ($employees > 0) {

                    $output = [
                        'success' => false,
                        'msg' => __('rrhh.item_has_childs'),
                    ];

                }

                $state->forceDelete();
                $output = [
                    'success' => true,
                    'msg' => __('geography.state_deleted'),
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

    public function getStatesData()
    {
        $business_id = request()->session()->get('user.business_id');
        $states = State::where('business_id', $business_id)->with('country', 'zone');

        return DataTables::of($states)->toJson();
    }

    public function getStates(): JsonResponse
    {
        $business_id = request()->session()->get('user.business_id');
        $states = State::where('business_id', $business_id)->get();

        return response()->json($states);
    }

    public function getStatesByCountry($id): JsonResponse
    {
        $business_id = request()->session()->get('user.business_id');
        $states = State::where('business_id', $business_id)
            ->where('country_id', $id)
            ->get();

        return response()->json($states);
    }
}
