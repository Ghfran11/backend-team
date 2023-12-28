<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Day;
use App\Http\Requests\StoredaysRequest;
use App\Http\Requests\UpdatedaysRequest;



class DaysController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $days = Day::query()->get();
        return ResponseHelper::success($days);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoredaysRequest $request)
    {   //day already has been validated in the request
        $day = Day::create([
            'name' => $request->name,
        ]);
        return ResponseHelper::success(['message'=>'day stored successfuly']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Day $day)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatedaysRequest $request, Day $day)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Day $Day)
    {
        $Day->delete();
        return ResponseHelper::success('Day deleted successfully');
    }
}
