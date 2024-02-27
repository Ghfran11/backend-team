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
        try {
            $days = Day::query()->get();
            return ResponseHelper::success($days);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoredaysRequest $request)
    {
        try {
            Day::create([
                'name' => $request->name,
            ]);
            return ResponseHelper::success(['message' => 'day stored successfully']);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function destroy(Day $Day)
    {
        try {
            $Day->delete();
            return ResponseHelper::success('Day deleted successfully');
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }

    }
}
