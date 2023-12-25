<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Time;
use App\Http\Requests\StoretimeRequest;
use App\Http\Requests\UpdatetimeRequest;
use App\Models\User;
use Illuminate\Http\Request;
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
        $time=Time::query()->create(
            [
                'userId'=>Auth::id(),
                'startTime'=>$request->startTime,
                'endTime'=>$request->endTime,
                'dayId'=>$request->dayId,
                'status'=>$request->status
            ]
            );

        return ResponseHelper::success($time);

    }

    /**
     * Display the specified resource.
     */
    public function show(Time $time)
    {
        $result=$time->get();
        return ResponseHelper::success($result);
    }


    public function showUserTime(Request $request,User $user)
    {

        $time=$user->time()->where('status',$request->status)
        ->with('days')
        ->get()
        ->toArray();
        return ResponseHelper::success($time);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatetimeRequest $request, Time $time)
    {
        $result=$time->update(
            [
                'userId'=>$request->userId,
                'startTime'=>$request->atartTime,
                'endTime'=>$request->endTime,
                'dayId'=>$request->dayId,
                'status'=>$request->status

            ]
            );
            return ResponseHelper::success(
                [
                    'message'=>'program updated successfuly',
                    'data'=>$result,
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
        return ResponseHelper::success(['message'=>'deleted successfuly']);


    }
}
