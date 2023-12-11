<?php

namespace App\Http\Controllers;

use App\Models\time;
use App\Http\Requests\StoretimeRequest;
use App\Http\Requests\UpdatetimeRequest;

class TimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoretimeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(time $time)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatetimeRequest $request, time $time)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(time $time)
    {
        //
    }
}
