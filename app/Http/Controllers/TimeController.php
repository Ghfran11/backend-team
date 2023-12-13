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
    if (Auth::user()->type == 'admin') {
        $time = Time::query()->create([
            'playerId' => null,
            'coachId' => null,
            'startTime' => $request->startTime,
            'endTime' => $request->endTime,
            'dayId' => $request->dayId,
        ]);
    } elseif (Auth::user()->type == 'coach') {
        $time = Time::query()->create([
            'playerId' => null,
            'coachId' => Auth::user()->id,
            'startTime' => $request->startTime,
            'endTime' => $request->endTime,
            'dayId' => $request->dayId,
        ]);
    } else {
        $time = Time::query()->create([
            'playerId' => Auth::user()->id,
            'coachId' => null,
            'startTime' => $request->startTime,
            'endTime' => $request->endTime,
            'dayId' => $request->dayId,
        ]);
    }



    return response($time, Response::HTTP_CREATED);
}

    /**
     * Display the specified resource.
     */
    public function show(Time $time)
    {
        $result=$time->get();
        return response($result,Response::HTTP_OK);

    }


    public function showCoachTime(Request $request)
    {
        $result = User::query()
            ->where('id', $request->id)
            ->where('type', 'coach')
            ->with('coach.days')
            ->get();

        $days = $result->pluck('coach');

        return ResponseHelper::success($days);
    }

    public function showPlayerTime(Request $request)
    {
        $result = User::query()
            ->where('id', $request->id)
            ->where('type', 'player')
            ->with('player.days')
            ->get();

        $days = $result->pluck('player');

        return ResponseHelper::success($days);
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
