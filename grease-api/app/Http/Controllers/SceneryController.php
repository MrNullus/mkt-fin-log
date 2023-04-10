<?php

namespace App\Http\Controllers;

use App\Models\Scenery;
use App\Http\Requests\StoreSceneryRequest;
use App\Http\Requests\UpdateSceneryRequest;

class SceneryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreSceneryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSceneryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Scenery  $scenery
     * @return \Illuminate\Http\Response
     */
    public function show(Scenery $scenery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Scenery  $scenery
     * @return \Illuminate\Http\Response
     */
    public function edit(Scenery $scenery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSceneryRequest  $request
     * @param  \App\Models\Scenery  $scenery
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSceneryRequest $request, Scenery $scenery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Scenery  $scenery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Scenery $scenery)
    {
        //
    }
}
