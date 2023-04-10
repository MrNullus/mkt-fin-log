<?php

namespace App\Http\Controllers;

use App\Models\CategorieMaterial;
use App\Http\Requests\StoreCategorieMaterialRequest;
use App\Http\Requests\UpdateCategorieMaterialRequest;

class CategorieMaterialController extends Controller
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
     * @param  \App\Http\Requests\StoreCategorieMaterialRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategorieMaterialRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CategorieMaterial  $categorieMaterial
     * @return \Illuminate\Http\Response
     */
    public function show(CategorieMaterial $categorieMaterial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CategorieMaterial  $categorieMaterial
     * @return \Illuminate\Http\Response
     */
    public function edit(CategorieMaterial $categorieMaterial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategorieMaterialRequest  $request
     * @param  \App\Models\CategorieMaterial  $categorieMaterial
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategorieMaterialRequest $request, CategorieMaterial $categorieMaterial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CategorieMaterial  $categorieMaterial
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategorieMaterial $categorieMaterial)
    {
        //
    }
}
