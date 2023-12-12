<?php

namespace App\Http\Controllers;

use App\Models\Time;
use App\Http\Requests\StoretimeRequest;
use App\Http\Requests\UpdatetimeRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Providers\Auth\Illuminate;

class TimeController extends Controller
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
    public function store(StoretimeRequest $request)
    {

        if(Auth::user()->type='admin')
        {
            $userId=$request->userId;

        }
        else{
            $userId=Auth::id();
        }
        $time=Time::query()->create(
            [
                'userId'=>$userId,
                'startTime'=>$request->atartTime,
                'endTime'=>$request->endTime,
                'dayId'=>$request->dayId,
            ]
            );

    return response($time,Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     */
    public function show(Time $time)
    {
        $result=$time->get();
        return response($result,Response::HTTP_OK);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatetimeRequest $request, Time $time)
    {
        $time->update(
            [
                'userId'=>$request->userId,
                'startTime'=>$request->atartTime,
                'endTime'=>$request->endTime,
                'dayId'=>$request->dayId,

            ]
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Time $time)
    {
        if(Auth::user()->type='admin' || Auth::id()== $time->userId )
        $time->delete();
        return response('time deleted successfully',Response::HTTP_OK);

    }

}
