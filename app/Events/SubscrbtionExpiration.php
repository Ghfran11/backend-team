<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubscrbtionExpiration implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    private $user;
    /**
     * Create a new event instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */


    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('subscription-expiration'),
        ];
    }

    public function broadcastWith()
    {
        return [
            'message' => 'Your subscription is expired !',
            'subscription_starts' => $this->user->created_at,
            'subscription_ends' => $newDate = $this->user->created_at->addMonth(),
        ];
    }
}
