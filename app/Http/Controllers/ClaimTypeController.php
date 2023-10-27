<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Models\Business;
use App\Models\Claim;
use App\Models\ClaimType;
use App\Models\ClaimTypeHasUser;
use App\Models\User;
use Carbon\Carbon;
use DataTables;
use DB;
use Illuminate\Http\Request;

class ClaimTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        if (! auth()->user()->can('claim_type.view')) {
            abort(403, 'Unauthorized action.');
        }

        return view('claims.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        if (! auth()->user()->can('claim_type.create')) {
            abort(403, 'Unauthorized action.');
        }

        return view('claims.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! auth()->user()->can('claim_type.create')) {
            abort(403, 'Unauthorized action.');
        }
        $validateData = $request->validate(
            [
                'txt-name-type' => 'required|unique:claim_types,name',
                'txt-resolution-time-type' => 'required|integer',

            ]
        );
        if ($request->ajax()) {
            try {

                $required_customer = $request->input('required_customer');
                $required_product = $request->input('required_product');
                $required_invoice = $request->input('required_invoice');
                $all_access_users = $request->input('all_access_users');

                $type_details['correlative'] = $request->input('txt-correlative-type');
                $type_details['name'] = $request->input('txt-name-type');
                $type_details['description'] = $request->input('txt-description-type');
                $type_details['resolution_time'] = $request->input('txt-resolution-time-type');

                if ($required_customer) {
                    $type_details['required_customer'] = 1;
                } else {
                    $type_details['required_customer'] = 0;
                }

                if ($required_product) {
                    $type_details['required_product'] = 1;
                } else {
                    $type_details['required_product'] = 0;
                }

                if ($required_invoice) {
                    $type_details['required_invoice'] = 1;
                } else {
                    $type_details['required_invoice'] = 0;
                }

                if ($all_access_users) {
                    $type_details['all_access'] = 1;
                } else {
                    $type_details['all_access'] = 0;
                }

                DB::beginTransaction();

                $type = ClaimType::create($type_details);

                $user_ids = $request->input('user_id');

                if (! empty($user_ids)) {
                    $cont = 0;
                    while ($cont < count($user_ids)) {
                        $detail = new ClaimTypeHasUser;
                        $detail->claim_type_id = $type->id;
                        $detail->user_id = $user_ids[$cont];
                        $detail->save();
                        $cont = $cont + 1;
                    }
                }

                DB::commit();
                $output = [
                    'success' => true,
                    'msg' => __('crm.added_success'),
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
     * @param  \App\Models\ClaimType  $claimType
     */
    public function show($id): JsonResponse
    {
        if (! auth()->user()->can('claim_type.view')) {
            abort(403, 'Unauthorized action.');
        }
        $type = ClaimType::findOrFail($id);

        return response()->json($type);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClaimType  $claimType
     */
    public function edit($id): JsonResponse
    {
        if (! auth()->user()->can('claim_type.update')) {
            abort(403, 'Unauthorized action.');
        }
        $type = ClaimType::findOrFail($id);

        return response()->json($type);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\ClaimType  $claimType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (! auth()->user()->can('claim_type.update')) {
            abort(403, 'Unauthorized action.');
        }

        $type = ClaimType::findOrFail($id);

        $validateData = $request->validate(
            [
                'txt-ename-type' => 'required|unique:claim_types,name,'.$type->id,
                'txt-eresolution-time-type' => 'required',
            ]
        );
        if ($request->ajax()) {
            try {

                $required_customer = $request->input('erequired_customer');
                $required_product = $request->input('erequired_product');
                $required_invoice = $request->input('erequired_invoice');
                $all_access_users = $request->input('eall_access_users');

                $type_details['name'] = $request->input('txt-ename-type');
                $type_details['description'] = $request->input('txt-edescription-type');
                $type_details['resolution_time'] = $request->input('txt-eresolution-time-type');

                if ($required_customer) {
                    $type_details['required_customer'] = 1;
                } else {
                    $type_details['required_customer'] = 0;
                }

                if ($required_product) {
                    $type_details['required_product'] = 1;
                } else {
                    $type_details['required_product'] = 0;
                }

                if ($required_invoice) {
                    $type_details['required_invoice'] = 1;
                } else {
                    $type_details['required_invoice'] = 0;
                }

                if ($all_access_users) {
                    $type_details['all_access'] = 1;
                } else {
                    $type_details['all_access'] = 0;
                }

                DB::beginTransaction();
                $type->update($type_details);

                $user_ids = $request->input('euser_id');
                ClaimTypeHasUser::where('claim_type_id', $type->id)->delete();
                if (! empty($user_ids)) {
                    $cont = 0;
                    while ($cont < count($user_ids)) {
                        $detail = new ClaimTypeHasUser;
                        $detail->claim_type_id = $type->id;
                        $detail->user_id = $user_ids[$cont];
                        $detail->save();
                        $cont = $cont + 1;
                    }
                }
                DB::commit();

                $output = [
                    'success' => true,
                    'msg' => __('crm.updated_success'),
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
     * @param  \App\Models\ClaimType  $claimType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! auth()->user()->can('claim_type.delete')) {
            abort(403, 'Unauthorized action.');
        }
        if (request()->ajax()) {
            try {

                $type = ClaimType::findOrFail($id);
                $claims = Claim::where('claim_type', $type->id)->count();

                if ($claims > 0) {
                    $output = [
                        'success' => false,
                        'msg' => __('crm.type_has_claims'),
                    ];
                } else {
                    $type->delete();
                    $output = [
                        'success' => true,
                        'msg' => __('crm.deleted_success'),
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

    public function getClaimTypesData()
    {
        if (! auth()->user()->can('claim_type.view')) {
            abort(403, 'Unauthorized action.');
        }
        $claimTypes = ClaimType::all();

        return DataTables::of($claimTypes)
            ->addColumn(
                'actions', function ($row) {
                    $html = '';

                    if (auth()->user()->can('claim.update')) {
                        $html .= '<a class="btn btn-xs btn-primary" onClick="editType('.$row->id.')"><i class="glyphicon glyphicon-edit"></i></a> ';
                    }

                    if (auth()->user()->can('claim.delete')) {
                        $html .= '<a class="btn btn-xs btn-danger" onClick="deleteType('.$row->id.')"><i class="glyphicon glyphicon-trash"></i></a>';
                    }

                    $html .= '';

                    return $html;
                })
            ->addColumn(
                'resolution', function ($row) {
                    $html = ''.$row->resolution_time.' '.__('crm.days').'';

                    return $html;
                })
            ->addColumn(
                'customer', function ($row) {
                    if ($row->required_customer == 1) {
                        return __('crm.yes');
                    } else {
                        return __('crm.no');
                    }
                })
            ->addColumn(
                'product', function ($row) {
                    if ($row->required_product == 1) {
                        return __('crm.yes');
                    } else {
                        return __('crm.no');
                    }
                })
            ->addColumn(
                'invoice', function ($row) {
                    if ($row->required_invoice == 1) {
                        return __('crm.yes');
                    } else {
                        return __('crm.no');
                    }
                })
            ->rawColumns(['actions'])
            ->toJson();
    }

    public function getClaimTypes(): JsonResponse
    {
        if (! auth()->user()->can('claim_type.view')) {
            abort(403, 'Unauthorized action.');
        }

        $claimTypes = ClaimType::all();

        return response()->json($claimTypes);
    }

    public function getClaimTypeCorrelative()
    {
        if (! auth()->user()->can('claim_type.create')) {
            abort(403, 'Unauthorized action.');
        }
        $business_id = request()->session()->get('user.business_id');
        $business = Business::where('id', $business_id)->first();

        $last_correlative = DB::table('claim_types')
            ->select(DB::raw('MAX(id) as max'))
            ->first();

        if ($last_correlative->max != null) {
            $correlative = $last_correlative->max + 1;
        } else {
            $correlative = 1;
        }
        if ($correlative < 10) {
            $correlative = ''.$business->claim_type_prefix.'0'.$correlative.'';
        } else {
            $correlative = ''.$business->claim_type_prefix.''.$correlative.'';
        }
        $output = [
            'correlative' => $correlative,
        ];

        return $output;
    }

    public function getUserById($id): JsonResponse
    {
        if (! auth()->user()->can('claim_type.create')) {
            abort(403, 'Unauthorized action.');
        }
        $user = User::select('id', DB::raw('CONCAT(first_name, " ", last_name) as full_name'))
            ->where('id', $id)
            ->first();

        return response()->json($user);
    }

    public function getUsersByClaimType($id): JsonResponse
    {
        if (! auth()->user()->can('claim_type.view')) {
            abort(403, 'Unauthorized action.');
        }
        $users = DB::table('claim_type_has_users as claim')
            ->join('users as user', 'user.id', '=', 'claim.user_id')
            ->select('claim.user_id', DB::raw('CONCAT(user.first_name, " ", user.last_name) as full_name'))
            ->where('claim.claim_type_id', $id)
            ->orderBy('claim.id', 'asc')
            ->get();

        return response()->json($users);
    }

    public function getSuggestedClosingDate($date, $days)
    {
        if (! auth()->user()->can('claim_type.create')) {
            abort(403, 'Unauthorized action.');
        }
        $date_claim = Carbon::createFromFormat('Y-m-d', $date);
        $date_claim->addDays($days);

        $output = [
            'suggested_date' => $date_claim->toDateString(),
            'date_claim' => $date,
            'days' => $days,
        ];

        return $output;
    }
}
