<?php

namespace App\Http\Controllers;

class CRMController extends Controller
{
    public function index()
    {
        if (! auth()->user()->can('crm-oportunities.view') && ! auth()->user()->can('crm-oportunities.create')) {
            abort(403, 'Unauthorized action.');
        }
        $business_id = request()->session()->get('user.business_id');

        return view('crm.index');
    }
}
