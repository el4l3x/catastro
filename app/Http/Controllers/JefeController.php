<?php

namespace App\Http\Controllers;

use App\Models\Jefe;
use App\Http\Requests\StoreJefeRequest;
use App\Http\Requests\UpdateJefeRequest;

class JefeController extends Controller
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
     * @param  \App\Http\Requests\StoreJefeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJefeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jefe  $jefe
     * @return \Illuminate\Http\Response
     */
    public function show(Jefe $jefe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jefe  $jefe
     * @return \Illuminate\Http\Response
     */
    public function edit(Jefe $jefe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateJefeRequest  $request
     * @param  \App\Models\Jefe  $jefe
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJefeRequest $request, Jefe $jefe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jefe  $jefe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jefe $jefe)
    {
        //
    }
}
