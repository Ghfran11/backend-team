<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Finance;
use App\Models\Report;

use App\Models\Rating;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\MonthService;

class UserController extends Controller
{
    public function showCoach()
    {
        try {
            $result = User::query()
                ->where('role', 'coach')
                ->with('image')
                ->get()
                ->toArray();

            if (empty($result)) {
                return ResponseHelper::error([], null, 'No coaches found', 204);
            }

            return ResponseHelper::success($result, null, 'Show Coaches', 200);
        } catch (\Exception $e) {
            return ResponseHelper::error([], null, $e->getMessage(), 500);
        }
    }

    public function showCoachInfo($id)
    {

        try {
            $result = User::query()
                ->where('id', $id)
                ->where('role', 'coach')
                ->with('image')
                ->get()
                ->toArray();
            if (empty($result)) {
                return ResponseHelper::error([], null, 'Coach not found', 202);
            }
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error([], null, $e->getMessage(), 500);
        }
    }

    public function showPlayer()
    {
        try {
            $result = User::query()
                ->where('role', 'player')
                ->with('image')
                ->get()
                ->toArray();
            if (empty($result)) {
                return ResponseHelper::error([], null, 'No players found', 204);
            }
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error([], null, $e->getMessage(), 500);
        }
    }

    public function playerInfo($id)
    {
        try {
            $result = User::query()
                ->where('id', $id)
                ->where('role', 'player')
                ->with('image')
                ->get()
                ->toArray();
            if (empty($result)) {
                return ResponseHelper::error([], null, 'User not found', 202);
            }
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error([], null, $e->getMessage(), 500);
        }
    }
    public function updateUser(User $user, Request $request)
    {
        $user->update(
            [
                'name' => $request->name,
                'birthDate' => $request->birthDate,
                'phoneNumber' => $request->phoneNumber,
                'role' => $request->role,
                'finance' => $request->finance


            ]

        );

        return ResponseHelper::success(['updated successfuly']);
    }
    public function deleteUser(User $user)
    {
        try {
            $user->rate()->delete();

            $result = $user->delete();

            if ($result) {
                return ResponseHelper::success(['message' => 'User deleted successfully']);
            } else {
                return ResponseHelper::error([], null, 'Failed to delete user', 500);
            }
        } catch (\Exception $e) {
            return ResponseHelper::error([], null, $e->getMessage(), 500);
        }
    }


    public function financial()
    {
        $payments = User::query()->where('role', 'coach')->sum('finance');
        $Imports = User::query()->where('role', 'player')->sum('finance');
        return ResponseHelper::success([
            'payments' => $payments,
            'Imports' => $Imports
        ]);
    }
    public function subscription()
    {
        $users = User::query()->where('role', 'player')->get()->toArray();
        foreach ($users as $user) {
            $userName = $user['name'];
            $expiration = Carbon::parse($user['expiration']);
            $now = Carbon::now();
            $remainingTime = $now->diffInDays($expiration, false);
            if ($remainingTime < 0) {
                $daysNotPaid = abs($remainingTime);
                $remainingTime = 0;

            } else {
                $daysNotPaid = 0;

            }
            $SubscriptionDate = $expiration->subMonth();
            $Paid = $user['is_paid'];
            $result = [
                'id' => $user['id'],
                'userNaname' => $userName,
                'remainingTime' => $remainingTime,
                'paidStatus' => $Paid,
                'SubscriptionDate' => $SubscriptionDate,
                'daysNotPaid' => $daysNotPaid,
            ];
            $results[] = $result;
        }
        return ResponseHelper::success($results);
    }
    public function updateSubscription(User $user, Request $request)
    {
        $subscriptionFee = $request->subscriptionFee;
        $currentMonth = Carbon::now()
            ->format('F');

        if ($user->is_paid == 'unpaid') {


            $user->update([

                'expiration' => now()->addMonth(),
                'finance' => $subscriptionFee

            ]);


            $resule = Finance::query()->create([
                'userId' => $user->id,
                'finance' => $subscriptionFee,
                'monthName' => $currentMonth
            ]);
            return ResponseHelper::updated('subscription added successfully');
        } else {
            return ResponseHelper::error([], null, 'this user was paid', 200);
        }
    }








    public function showCountPercentage(User $user, Request $request)
    {
        $fiveMonthsAgo = Carbon::now()->subMonths(5);

        $totalPlayers = $user->query()
            ->where('role', 'player')
            ->where('created_at', '>=', $fiveMonthsAgo)
            ->count();

        $monthlyCounts = $user->query()
            ->where('role', 'player')
            ->where('created_at', '>=', $fiveMonthsAgo)
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, count(*) as count')
            ->get()
            ->pluck('count', 'month');

        $percentageData = [];
        $totalPercentage = 0;

        $monthCursor = Carbon::parse($fiveMonthsAgo)->startOfMonth();
        while ($monthCursor <= Carbon::now()->startOfMonth()) {
            $month = $monthCursor->format('Y-m');
            $count = $monthlyCounts[$month] ?? 1;
            $percentage = $totalPlayers > 0 ? ($count / $totalPlayers) * 100 : 0;
            $totalPercentage += $percentage;
            $percentageData[$monthCursor->format('F')] = round($percentage, 2);
            $monthCursor->addMonth();
        }

        return ResponseHelper::success([
            'percentage_data' => $percentageData,
            'total_percentage' => round($totalPercentage, 2)
        ]);
    }





    public function financeMonth(Request $request, MonthService $monthService)
    {
        $previousMonths = $monthService->getPreviousMonths(5);

        $monthlyData = [];

        foreach ($previousMonths as $month) {
            $result = Finance::where('monthName', $month)
                ->sum('finance');

            $monthlyData[] = [
                'monthName' => $month,
                'finance' => $result,
            ];
        }

        return ResponseHelper::success($monthlyData);
    }


    public function mvpCoach()
    {
        $result = Rating::select('coachId')
            ->selectRaw('SUM(rate) as totalRate')
            ->groupBy('coachId')
            ->orderByDesc('totalRate')
            ->first();

        if ($result) {
            $coachId = $result->coachId;
            $coach = User::with('image')->find($coachId);

            if ($coach && $coach->image) {
                $coachWithImage = $coach;
                $coachWithImage->image;
                return ResponseHelper::success($coachWithImage);
            } else {
                return ResponseHelper::success([], null, 'No coaches found', 202);
            }
        } else {
            return ResponseHelper::success([], null, 'No coaches found', 202);
        }
    }


    public function search(Request $request)
    {
        $search = $request->input('search_text');
        $oppositeRole = Auth::user()->role == 'player' ? 'coach' : 'player';
        $users = User::query()
            ->when(in_array(Auth::user()->role, ['player', 'coach']), function ($query) use ($oppositeRole) {
                return $query->where('role', $oppositeRole);
            })
            ->where('name', 'LIKE', "%{$search}%")
            ->get();
        return ResponseHelper::success($users);
    }


    public function statistics()
    {
        $numofplayers = User::where('role', 'player')->pluck('expiration');
        $now_date = Carbon::now();

        foreach ($numofplayers as $expiration) {
            $not_expired = $numofplayers->filter(function ($expiration) use ($now_date) {
                $expirationDate = Carbon::parse($expiration);
                return $expirationDate->diffInDays($now_date) < 31;
            })->count();
        }

        $numOfCoach = User::where('role', 'coach')->count();
        $reports = Report::get();
        $numOfReports = $reports->count();

        return ResponseHelper::success([
            'players'      => $not_expired,
            'coaches' =>  $numOfCoach,
            'subscriptionFee' => 2000000,
            'numOfReports' => $numOfReports
        ]);
    }



    public function showAnnual(Request $request){


        $lastYear = date('Y') ;

        $result = Finance::whereYear('created_at', $lastYear)
            ->sum('finance');

        return responseHelper::success(['Annual finance :'=>$result]);

    }
}
