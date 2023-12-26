<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Rating;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                return ResponseHelper::error([], null, 'Coach not found', 404);
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
            ->get();
        if ($result->isEmpty()) {
            return ResponseHelper::error([], null, 'User not found', 404);
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
                'birthDate'=>$request->birthDate,
                'phoneNumber'=>$request->phoneNumber,
                'role'=>$request->role,

            ]

            );
            $result=$user->get();
            return ResponseHelper::success($result);
    }
    public function deleteUser(User $user)
    {
        try {
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



    public function showPercentage(User $user, Request $request)
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


    public function mvpCoach()
    {
        $currentMonth = Carbon::now()->startOfMonth();
        $coaches = User::where('role', 'coach')->get();

        $coachRatings = [];

        foreach ($coaches as $coach) {
            $rating = Rating::where('coachId', $coach->id)
                ->whereMonth('created_at', $currentMonth->month)
                ->sum('rate');

            $coachRatings[] = [
                'coach' => $coach,
                'rating' => $rating,
            ];
        }

        usort($coachRatings, function ($a, $b) {
            return $b['rating'] - $a['rating'];
        });

        return $coachRatings;
    }

}
