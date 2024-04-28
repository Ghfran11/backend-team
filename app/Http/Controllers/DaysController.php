<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Day;
use App\Http\Requests\StoredaysRequest;

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
    {
        Day::create([
            'name' => $request->name,
        ]);
        return ResponseHelper::success(['message' => 'day stored successfully']);
    }

    public function destroy(Day $Day)
    {
        $Day->delete();
        return ResponseHelper::success('Day deleted successfully');
    }
}
