<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Time;
use App\Http\Requests\StoretimeRequest;
use App\Http\Requests\UpdatetimeRequest;
use App\Models\User;
use Carbon\Carbon;
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
    public function storeUserTime()
    {
        $time = Time::query()->create([
            'userId' => Auth::id(),
            'startTime' => now()->format('Y-m-d H:i:s'),
            'isCoach' => '0',
            'dayId'=>null
        ]);

        return ResponseHelper::success($time,null,'success',200);
    }


    public function storeCoachTime(StoretimeRequest $request)
    {
        $time = Time::query()
        ->create([
            'userId' => Auth::id(),
            'isCoach' => '1',
            'dayId'=>$request->dayId,
            'startTime'=>$request->startTime,
            'endTime'=>$request->endTime
        ]);

        return ResponseHelper::success($time,null,'success',200);
    }


    public function endCounter(Request $request){
        $result = Time::query()
        ->where('userId', Auth::user()->id)
        ->whereNotNull('startTime')
        ->whereNull('endTime')
        ->update(['endTime' => Carbon::now()
        ->format('Y-m-d H:i:s')]);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {$user=User::find(Auth::id());
        $result=$user->time()->get()
        ->map(function ($item) {
            $startTime = Carbon::parse($item['startTime'])
            ->format('l');
            $item['startTimeWithDate'] = $startTime;
            return $item;
        })
        ->toArray();
        return ResponseHelper::success($result);
    }


    public function showUserTime(User $user)
    {
        $time = $user->time()->where('isCoach','0')
        ->get()
        ->map(function ($item) {
            $startTime = Carbon::parse($item['startTime'])
            ->format('l');
            $item['startTimeWithDate'] = $startTime;
            return $item;
        })
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


    public function activePlayersCounter()
    {
        //select only the 'endTime' column , we don't want the other details of the records...
        $endtimes = Time::select('endTime')
                    ->whereNull('endTime')
                    ->count();

        return ResponseHelper::success([$endtimes]);
    }

    public function activePlayers()
    {
        $activeplayers = Time::whereNull('endTime')
                        ->with('user')
                        ->get()
                        ->toArray();

        return ResponseHelper::success($activeplayers);
    }
}
