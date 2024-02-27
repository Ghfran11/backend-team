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
    public function index()
    {
        $subscriptions = Order::where('status', 'accepted')
            ->orderBy('created_at', 'desc')
            ->get()->toArray();
        return ResponseHelper::success($subscriptions);
    }

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
            if ($totalOrderCount == 0) {
                return ResponseHelper::error('There is no Orders');
            }
            $dailyOrderCounts = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
                ->where('status', 'accepted')
                ->where('coachId', $coach_id)
                ->whereYear('created_at', date('Y'))
                ->groupBy(DB::raw('DATE(created_at)'))
                ->get();
            $allMonths = collect([
                'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
            ]);
            $monthlyOrderCounts = $dailyOrderCounts
                ->groupBy(function ($date) {
                    return Carbon::parse($date->date)->format('M');
                });
            $monthlyOrderPercentages = $allMonths
                ->mapWithKeys(function ($month) use ($monthlyOrderCounts, $totalOrderCount) {
                    $data = $monthlyOrderCounts->get($month, collect());
                    $percentage = ($data->sum('count') / $totalOrderCount) * 100;
                    $formattedPercentage = number_format($percentage) . '%';
                    return [$month => $formattedPercentage];
                });
            return ResponseHelper::success(array_values($monthlyOrderPercentages->toArray()));
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

}
