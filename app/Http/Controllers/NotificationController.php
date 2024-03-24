<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() //list of 10 notifications
    {
        try {
            $notifications = Notification::query()->where('receiver_id', Auth::id())
                ->orderBy('created_at', 'desc')->get()->toArray();
                
            return ResponseHelper::success($notifications);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }
}
