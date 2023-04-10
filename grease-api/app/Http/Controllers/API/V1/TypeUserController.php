<?php

namespace App\Http\Controllers;

use App\Models\TypeUser;
use App\Http\Requests\StoreTypeUserRequest;
use App\Http\Requests\UpdateTypeUserRequest;

class TypeUserController extends Controller
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
     * @param  \App\Http\Requests\StoreTypeUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTypeUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TypeUser  $typeUser
     * @return \Illuminate\Http\Response
     */
    public function show(TypeUser $typeUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TypeUser  $typeUser
     * @return \Illuminate\Http\Response
     */
    public function edit(TypeUser $typeUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTypeUserRequest  $request
     * @param  \App\Models\TypeUser  $typeUser
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTypeUserRequest $request, TypeUser $typeUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TypeUser  $typeUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeUser $typeUser)
    {
        //
    }
}
