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
        try {
            $days = Day::query()->get();
            return ResponseHelper::success($days);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ResponseHelper::error($e->validator->errors()->first(), 400);
        } catch (\Illuminate\Database\QueryException $e) {
            return ResponseHelper::error('Query Exception', 400);
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
            return ResponseHelper::success(['message' => 'day stored successfuly']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ResponseHelper::error($e->validator->errors()->first(), 400);
        } catch (\Illuminate\Database\QueryException $e) {
            return ResponseHelper::error('Query Exception', 400);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
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
        try {
            $Day->delete();
            return ResponseHelper::success('Day deleted successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ResponseHelper::error($e->validator->errors()->first(), 400);
        } catch (\Illuminate\Database\QueryException $e) {
            return ResponseHelper::error('Query Exception', 400);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }

    }
}
