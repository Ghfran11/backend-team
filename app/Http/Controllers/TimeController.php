<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Time;
use App\Http\Requests\StoretimeRequest;
use App\Http\Requests\UpdatetimeRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function storeUserTime()
    {
        $today = Carbon::today()->toDateString();
        $existingRecord = Time::where('userId', Auth::id())
            ->whereDate('startTime', $today)
            ->whereNull('endTime')
            ->first();
        if ($existingRecord) {
            return ResponseHelper::error('You are already scanned the QR.', 400);
        }
        $time = Time::query()->updateOrCreate([
            'userId' => Auth::id(),
            'startTime' => now()->format('Y-m-d H:i:s'),
            'isCoach' => '0',
            'dayId' => null
        ]);
        return ResponseHelper::success($time, null, 'success', 200);
    }

    public function storeCoachTime(StoretimeRequest $request)
    {
        foreach ($request->coachTime as $item) {
            $time = Time::query()
                ->create([
                    'userId' => $request->coachId,
                    'isCoach' => '1',
                    'dayId' => $item['dayId'],
                    'startTime' => $item['startTime'],
                    'endTime' => $item['endTime']
                ]);
            $results[] = $time;
        }
        return ResponseHelper::success($results, null, 'success', 200);
    }

    public function CoachMyTime(StoretimeRequest $request)
    {
        foreach ($request->coachTime as $item) {
            $time = Time::query()
                ->create([
                    'userId' => $request->coachId,
                    'isCoach' => '1',
                    'dayId' => $item['dayId'],
                    'startTime' => $item['startTime'],
                    'endTime' => $item['endTime']
                ]);
            $results[] = $time;
        }
        return ResponseHelper::success($results, null, 'success', 200);
    }

    public function showCoachTime(User $user)
    {
        $result = $user->time()->get(['startTime', 'endTime', 'dayId'])->toArray();
        return ResponseHelper::success($result, null, 'success', 200);
    }

    public function endCounter(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $result = Time::where('userId', Auth::id())
            ->whereDate('startTime', $today)
            ->whereNull('endTime')
            ->latest()->first();
        if ($result) {
            $result->update([
                'endTime' => Carbon::now()
                    ->format('Y-m-d H:i:s')
            ]);
            return ResponseHelper::success('Done', 'success', 200);
        }
        return ResponseHelper::error('You have alredy closed the counter Or You havent started yet.');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = User::find(Auth::id());
        $program = $user->playerPrograms()->get()->pluck('pivot.startDate');
        if ($program->isEmpty()) {
            return ResponseHelper::success('empty');
        }
        $result = $user->time()
            ->get()
            ->filter(function ($item) use ($program) {
                $startTime = Carbon::parse($item['startTime']);
                $startDate = Carbon::parse($program[0]);
                return $startTime->lessThan($startDate);
            })
            ->count();
        return ResponseHelper::success($result);
    }


    public function showUserTime(User $user)
    {
        $time = $user->time()->where('isCoach', '0')
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
        $user = User::find(Auth::id());
        $result = $time->update(
            [
                'userId' => $user->id,
                'startTime' => $request->atartTime,
                'endTime' => $request->endTime,
                'dayId' => $request->dayId,
            ]
        );
        return ResponseHelper::success(
            [
                'message' => 'time updated successfuly',
                'data' => $result,
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Time $time)
    {
        if (Auth::user()->type = 'admin' || Auth::id() == $time->userId)
            $time->delete();
        return ResponseHelper::success(['message' => 'deleted successfuly']);
    }

    public function activePlayersCounter()
    {
        //select only the 'endTime' column , we don't want the other details of the records...
        $endtimes = Time::select('endTime')
            ->whereNull('endTime')
            ->count();
        $numofplayers = User::where('role', 'player')->pluck('expiration');
        $now_date = Carbon::now();
        foreach ($numofplayers as $expiration) {
            $not_expired = $numofplayers->filter(function ($expiration) use ($now_date) {
                $expirationDate = Carbon::parse($expiration);
                return $expirationDate->diffInDays($now_date) < 31;
            })->count();
        }
        return ResponseHelper::success([
            'active_players' => !empty($endtimes) ? $endtimes : 0,
            'total_players' => !empty($not_expired) ? $not_expired : 0,
        ]);
    }

    public function activePlayers()
    {
        $this->endCounters();
        $activeplayers = Time::whereNull('endTime')
            ->with('user')
            ->get()
            ->toArray();
        if (count($activeplayers) > 5) {
            $isTraffic = true;
        } else {
            $isTraffic = false;
        }
        $result = [
            'activePlayer' => $activeplayers,
            'isTraffic' => $isTraffic
        ];
        return ResponseHelper::success($result);
    }

    public function monthlyProgress()
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $user = User::find(Auth::id());
        $result = $user->time()->whereBetween('startTime', [$startDate, $endDate])
            ->pluck('startTime');

        $checkinStatus = Auth::user()->checkinStatus;
        return ResponseHelper::success([$result, 'checkinStatus' => $checkinStatus]);
    }

    public function weeklyProgress()
    {
        $startDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();
        $user = User::find(Auth::id());
        $result = $user->time()->whereBetween('startTime', [$startDate, $endDate])->get();
        $daysOfWeek = [];
        foreach ($result as $result) {
            $day = Carbon::parse($result->startTime)->startOfDay();
            $daysOfWeek[] = $day->format('l'); // Eg "Monday"
        }
        return ResponseHelper::success($daysOfWeek);
    }


    public function endCounters()
    {
        $now = Carbon::now();
        $times = Time::query()->where('endTime', null)->get();
        foreach ($times as $time) {
            $startTime = Carbon::parse($time->startTime);
            $sub = $startTime->diffInHours($now);
            if ($sub > 3) {
                $time->update(
                    [
                        'endTime' => $now
                    ]
                );
            }
        }
        return ResponseHelper::success('successfully');
    }
}
