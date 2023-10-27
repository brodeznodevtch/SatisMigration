<?php

namespace Modules\Restaurant\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): View
    {
        return view('restaurant::index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): View
    {
        return view('restaurant::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request): Response
    {
    }

    /**
     * Show the specified resource.
     *
     * @return Response
     */
    public function show(): View
    {
        return view('restaurant::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(): View
    {
        return view('restaurant::edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(Request $request): Response
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(): Response
    {
    }
}
