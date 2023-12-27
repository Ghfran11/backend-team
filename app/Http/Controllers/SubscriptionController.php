<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
}
