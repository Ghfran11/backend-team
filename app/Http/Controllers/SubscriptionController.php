<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        try {
            $result = User::query()
                ->where('id', $request->id)
                ->update([
                    'expiration' => Carbon::now(),
                ]);
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function monthlySubscriptionAvg()
    {
        try {
            $coach_id = Auth::id();
            $totalOrderCount = Order::whereYear('created_at', date('Y'))->count();
            $dailyOrderCounts = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
                ->where('status', 'accepted')
                ->where('coachId', $coach_id)
                ->whereYear('created_at', date('Y'))
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();
            $monthlyOrderPercentages = $dailyOrderCounts
                ->groupBy(function ($date) {
                    return Carbon::parse($date->date)->format('Y-m');
                })
                ->map(function ($data) use ($totalOrderCount) {
                    $percentage = ($data->sum('count') / $totalOrderCount) * 100;
                    return number_format($percentage, 1) . '%';
                });
            return ResponseHelper::success($monthlyOrderPercentages);

        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

}
