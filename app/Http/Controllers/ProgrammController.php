<?php

namespace App\Http\Controllers;

use App\Models\Programme;
use App\Http\Requests\StoreprogrammRequest;
use App\Http\Requests\UpdateprogrammRequest;

class ProgrammController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreprogrammRequest $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(Programme $programme)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateprogrammRequest $request, Programme $programme)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(programme $programme)
    {
        //
    }
}
