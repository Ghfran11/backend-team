<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Notification;
use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() //list of 10 notifications
    {
        try {
            $notifications = Notification::query()->where('receiver_id', Auth::id())
                ->orderBy('created_at', 'desc')->get();
            return ResponseHelper::success($notifications);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }
}
