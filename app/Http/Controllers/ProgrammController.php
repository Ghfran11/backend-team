<?php

namespace App\Http\Controllers;

use App\Models\programm;
use App\Http\Requests\StoreprogrammRequest;
use App\Http\Requests\UpdateprogrammRequest;

class ProgrammController extends Controller
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
    public function store(StoreprogrammRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(programm $programm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateprogrammRequest $request, programm $programm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(programm $programm)
    {
        //
    }
}
