<?php

namespace App\Http\Controllers;

use App\Models\Caixa;
use App\Http\Requests\StoreCaixaRequest;
use App\Http\Requests\UpdateCaixaRequest;

class CaixaController extends Controller
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
     * @param  \App\Http\Requests\StoreCaixaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCaixaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Caixa  $caixa
     * @return \Illuminate\Http\Response
     */
    public function show(Caixa $caixa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Caixa  $caixa
     * @return \Illuminate\Http\Response
     */
    public function edit(Caixa $caixa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCaixaRequest  $request
     * @param  \App\Models\Caixa  $caixa
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCaixaRequest $request, Caixa $caixa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Caixa  $caixa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Caixa $caixa)
    {
        //
    }
}
