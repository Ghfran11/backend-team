<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Exercise;
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
        $result= Exercise::query()->get();
        return ResponseHelper::success($result);
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


            return ResponseHelper::success($exercie);
    }

    /**
     * Display the specified resource.
     */
    public function show(Exercise $exercise)
    {
       $result['exercise']=$exercise;
       $result['images']=$exercise->image();

       //هاد الكود بيجيب كلشي اكسرسايز مو اللي نحنا بدنا ياه ةالميثود هي وظيفتا تفرجينا التفاصيل

        // $result= Exercise::query()
        // ->with('image')->get();
       return ResponseHelper::success($result);
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
