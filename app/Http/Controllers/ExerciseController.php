<?php

namespace App\Http\Controllers;

use App\Models\exercise;
use App\Http\Requests\StoreexerciseRequest;
use App\Http\Requests\UpdateexerciseRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Exercise as ModelsExercise;

class ExerciseController extends Controller
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
    public function store(StoreexerciseRequest $request)
    {

        $exercie=Exercise::query()->create(
            [
                'name'=>$request->name,
                'description'=>$request->description
            ]
            );


    return response($exercie,Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Exercise $exercise)
    {
       $result['exercise']=$exercise->get();
       $result['images']=$exercise->image()->get();


       return response($result,Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateexerciseRequest $request, exercise $exercise)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(exercise $exercise)
    {
        //
    }
}
