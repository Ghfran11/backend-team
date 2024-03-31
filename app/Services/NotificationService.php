<?php


namespace App\Services;


use App\Enum\NotificationType;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    public function acceptOrderNotification($user, $player_id)
    {
        Notification::query()->Create([
            'type' => NotificationType::ACCEPT_ORDER,
            'title' => 'Order Accepted !',
            'content' => 'You have been accepted by the coach ' . $user->name . ' to his program.',
            'date' => Carbon::now()->format('Y-m-d'),
            'receiver_id' => $player_id,
        ]);
        return true;
    }
}
