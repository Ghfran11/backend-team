<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Exercise;
use App\Http\Requests\StoreexerciseRequest;


class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $result = Exercise::query()->get();
            return ResponseHelper::success($result);
        }  catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreexerciseRequest $request)
    {
        try {
            $exercie = Exercise::query()->create(
                [
                    'name' => $request->name,
                    'description' => $request->description
                ]
            );
            return ResponseHelper::success($exercie);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Exercise $exercise)
    {
        try {
            $result['exercise'] = $exercise;
            $result['images'] = $exercise->image();
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

}
