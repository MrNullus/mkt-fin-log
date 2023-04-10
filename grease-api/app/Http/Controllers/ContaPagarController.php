<?php

namespace App\Http\Controllers;

use App\Models\ContaPagar;
use App\Http\Requests\StoreContaPagarRequest;
use App\Http\Requests\UpdateContaPagarRequest;

class ContaPagarController extends Controller
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
     * @param  \App\Http\Requests\StoreContaPagarRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContaPagarRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContaPagar  $contaPagar
     * @return \Illuminate\Http\Response
     */
    public function show(ContaPagar $contaPagar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContaPagar  $contaPagar
     * @return \Illuminate\Http\Response
     */
    public function edit(ContaPagar $contaPagar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateContaPagarRequest  $request
     * @param  \App\Models\ContaPagar  $contaPagar
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContaPagarRequest $request, ContaPagar $contaPagar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContaPagar  $contaPagar
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContaPagar $contaPagar)
    {
        //
    }
}
