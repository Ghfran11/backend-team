<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $result = User::query()
            ->where('id', $request->id)
            ->update([
                'expiration' => Carbon::now(),
            ]);

        return ResponseHelper::success($result);
    }

    public function monthlySubscriptionAvg(Request $request)
    {
        $coach_id = Auth::id();
        $now = Carbon::now();
        $fiveMonthsAgo = $now->copy()->subMonths(5);
        $orderCount = Order::where('coachId', $coach_id)
            ->where('status', 'accepted')
            ->whereBetween('created_at', [$fiveMonthsAgo, $now])
            ->count();
        $average = number_format(($orderCount / 6) * 100, 1);
        $avg=$average . "%";
        return ResponseHelper::success($avg);
    }
}
