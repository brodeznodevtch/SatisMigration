<?php

namespace App\Http\Controllers;

use App\Models\RrhhHeader;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RrhhHeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {

        if (! auth()->user()->can('rrhh_catalogues.view')) {
            abort(403, 'Unauthorized action.');
        }

        return view('rrhh.catalogues.index');
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
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(RrhhHeader $rrhhHeader)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(RrhhHeader $rrhhHeader)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RrhhHeader $rrhhHeader)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(RrhhHeader $rrhhHeader)
    {
        //
    }
}
