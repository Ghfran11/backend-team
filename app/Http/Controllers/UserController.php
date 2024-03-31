<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Finance;
use App\Models\Report;
use App\Models\Info;
use App\Models\Rating;
use App\Models\User;
use App\Models\Program;
use App\Models\UserInfo;
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
            if (empty ($result)) {
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
            if (empty ($result)) {
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
            if (empty ($result)) {
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
                ->first()
                ->toArray();
            if (empty ($result)) {
                return ResponseHelper::error([], null, 'User not found', 202);
            }
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error([], null, $e->getMessage(), 500);
        }
    }

    public function updateUser(User $user, Request $request)
    {
        try {
            $user->update(
                [
                    'name' => $request->name,
                    'birthDate' => $request->birthDate,
                    'phoneNumber' => $request->phoneNumber,
                    'role' => $request->role,
                    'finance' => $request->finance,
                ]
            );
            return ResponseHelper::success(['updated successfully']);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
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
        try {
            $payments = User::query()->where('role', 'coach')->sum('finance');
            $Imports = User::query()->where('role', 'player')->sum('finance');
            return ResponseHelper::success([
                'payments' => $payments,
                'Imports' => $Imports
            ]);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function subscription()
    {
        try {
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
            return ResponseHelper::success($results);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function updateSubscription(User $user)
    {
        try {
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
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function showCountPercentage(User $user)
    {
        try {
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
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function financeMonth(MonthService $monthService)
    {
        try {
            $previousMonths = $monthService->getPreviousMonths(7);
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
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }


    public function mvpCoach()
    {
        try {
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
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }


    public function search(Request $request)
    {
        try {
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
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }


    public function statistics()
    {
        try {
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
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }


    public function showAnnual(Request $request)
    {
        try {
            $lastYear = date('Y');
            $result = Finance::whereYear('created_at', $lastYear)
                ->sum('finance');
            $year = date('Y');
            return responseHelper::success(['Annual_finance' => $result, 'year' => $year]);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function info()
    {
        try {
            $user = User::find(Auth::id());
            $userOrder[] = $user->playerOrder()->where('type', 'join')->get();

            if (!empty ($userOrder)) {
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
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

}
