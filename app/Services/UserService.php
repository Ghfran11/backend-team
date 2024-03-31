<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Info;
use App\Models\User;
use App\Models\Rating;
use App\Models\Report;
use App\Models\Finance;
use App\Models\UserInfo;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function ShowCoachs()
    {
        $result = User::query()
            ->where('role', 'coach')
            ->with('image')
            ->get()
            ->toArray();
        if (empty($result)) {
            return ResponseHelper::error([], null, 'No coaches found', 204);
        }

        return $result;
    }

    public function coachinfo($id)
    {
        $result = User::query()
            ->where('id', $id)
            ->where('role', 'coach')
            ->with('image')
            ->get()
            ->toArray();
        if (empty($result)) {
            return ResponseHelper::error([], null, 'Coach not found', 202);
        }

        return $result;
    }

    public function ShowPlayers()
    {
        $result = User::query()
            ->where('role', 'player')
            ->with('image')
            ->get()
            ->toArray();
        if (empty($result)) {
            return ResponseHelper::error([], null, 'No players found', 204);
        }

        return $result;
    }

    public function playerinfo($id)
    {
        $result = User::query()
            ->where('id', $id)
            ->where('role', 'player')
            ->with('image')
            ->first()
            ->toArray();
        if (empty($result)) {
            return ResponseHelper::error([], null, 'User not found', 202);
        }

        return $result;
    }

    public function UpdateUser($user, $request)
    {
        $edited = $user->update($request);
        return $edited ? ResponseHelper::success(['updated successfully']) :
            ResponseHelper::error([], null, "Error updating the user", 500);
    }

    public function DeleteUser($user)
    {
        $user->rate()->delete();
        $result = $user->delete();

        return $result ? ResponseHelper::success(['message' => 'User deleted successfully']) :
            ResponseHelper::error([], null, 'Failed to delete user', 500);
    }

    public function GetFinance()
    {
        $payments = User::query()->where('role', 'coach')->sum('finance');
        $Imports = User::query()->where('role', 'player')->sum('finance');
        return ResponseHelper::success([
            'payments' => $payments,
            'Imports' => $Imports
        ]);
    }

    public function CheckSubscription()
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
                'userName' => $userName,
                'remainingTime' => $remainingTime,
                'paidStatus' => $Paid,
                'SubscriptionDate' => $SubscriptionDate,
                'daysNotPaid' => $daysNotPaid,
            ];
            $results[] = $result;
        }

        return $results;
    }

    public function RenewSubscription($user)
    {
        $finance = Info::query()->value('finance');
        $currentMonth = Carbon::now()
            ->format('F');
        if ($user->is_paid == 'unpaid') {
            $user->update([
                'expiration' => now()->addMonth(),
                'finance' => $finance
            ]);
            Finance::query()->create([
                'userId' => $user->id,
                'finance' => $finance,
                'monthName' => $currentMonth
            ]);
            return ResponseHelper::updated('subscription added successfully');
        } else {
            return ResponseHelper::error([], null, 'this user was paid', 200);
        }
    }

    public function showCountPercentage($user)
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

    public function financeMonth($previousMonths)
    {
        $monthlyData = [];
        foreach ($previousMonths as $month) {
            $result = Finance::where('monthName', $month)
                ->sum('finance');
            $monthlyData[] = [
                'monthName' => $month,
                'finance' => $result,
            ];
        }
        return $monthlyData;
    }

    public function MVPcoach()
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

    public function Search($request)
    {
        $search = $request->input('search_text');
        $user = User::find(Auth::id());
        if ($user->role == 'player') {
            $users = User::query()->where('role', 'coach')
                ->where('name', 'LIKE', "%{$search}%")
                ->get()
                ->toArray();
            return ResponseHelper::success($users);
        } elseif ($user->role == 'coach') {
            $result = $user->where('name', 'LIKE', "%{$search}%")
                ->whereHas('coachOrder', function ($query) use ($request) {
                    $query->where('status', 'accepted');
                })
                ->get()
                ->toArray();
            return ResponseHelper::success($result);
        }
        $users = User::all();
        return ResponseHelper::success($users);
    }

    public function Statistics()
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
            'players' => $not_expired,
            'coaches' => $numOfCoach,
            'subscriptionFee' => 2000000,
            'numOfReports' => $numOfReports
        ]);
    }

    public function Annual()
    {
        $lastYear = date('Y');
        $result = Finance::whereYear('created_at', $lastYear)
            ->sum('finance');
        $year = date('Y');
        return responseHelper::success(['Annual_finance' => $result, 'year' => $year]);
    }

    public function Info()
    {
        $user = User::find(Auth::id());
            $userOrder[] = $user->playerOrder()->where('type', 'join')->get();

            if (!empty($userOrder)) {
                $status = $user->playerOrder()->where('type', 'join')->value('status');

                if ($status == 'accepted') {
                    $hasCoach = 'true';
                    $mycoach = $user->playerOrder()->where('type', 'join')->with('coach')->get();
                } else {
                    $hasCoach = 'false';
                    $mycoach = null;
                }
            }
            $userInfo = UserInfo::query()->where('userId', $user->id)->value('id');
            $info = UserInfo::find($userInfo);
            $foodProgram = $info->program()->whereHas('category', function ($query) {
                $query->where('type', 'food');
            })->get()
                ->toArray();
            $sportProgram = $info->program()->whereHas('category', function ($query) {
                $query->where('type', 'sport');
            })
                ->get()
                ->toArray();
            $result = [
                'hasCoach' => $hasCoach,
                'myCoach' => $mycoach,
                'foodProgram' => $foodProgram,
                'sportProgram' => $sportProgram
            ];
            return responseHelper::success([$result]);
    }
}
