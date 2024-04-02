<?php

namespace App\Services;

use App\Models\order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function store($request)
    {

        $existOrder = Order::where('playerId', Auth::id())
            ->where('coachId', $request->coachId)->exists();
        if ($existOrder) {
            return 'You already sent an order to this coach !';
        }
        $Order = Order::query()->create(
            [
                'coachId' => $request->coachId,
                'playerId' => Auth::id(),
                'type' => 'join',
            ]
        );
        return $Order;
    }

    public function show($order)
    {

        $result = $order->get()->toArray();
        return $result;
    }

    public function update($request, $order)
    {

        if ($order->status = 'waiting') {
            $order = Order::query()->update(
                [
                    'coachId' => $request->coachId,
                    'playerId' => $request->playerId,
                ]
            );
            return $order;

        }
    }

    public function destroy(order $order)
    {

        if ($order->status = 'waiting') {
            $order->delete();
        }
        return 'deleted successfully';

    }

    public function getMyOrder(Request $request) //as a coach or a player , iwant to show my order which
    {

        $user = User::find(Auth::id());

        $result = [];
        if ($user->role == 'coach') {
            if ($request->type == 'join') {

                $result = $user->coachOrder()->with('player.image')->get()->toArray();
            } elseif ($request->type == 'food') {
                $result = $user->coachOrder()->with('player.image')->where('type', 'food')->get()->toArray();
            } elseif ($request->type == 'sport') {
                $result = $user->coachOrder()->with('player.image')->where('type', 'sport')->get()->toArray();
            } else {

                $result = $user->coachOrder()->with('player.image')->get()->toArray();
            }
        }
        if ($user->role == 'player') {
            if ($request->type == 'join') {

                $result = $user->playerOrder()->where('type', 'join')->get()->toArray();
                //dd($result);
            }
            if ($request->type == 'food') {
                $result = $user->playerOrder()->where('type', 'food')->get()->toArray();
            }
            if ($request->type == 'training') {
                $result = $user->playerOrder()->where('type', 'training')->get()->toArray();
            }
        }
        return $result;

    }

    public function acceptOrder(Order $order) //as a coach i want to accept the join order from the player
    {

        if ($order->coachId == Auth::id()) {

            if ($order->status == 'waiting' && $order->type == 'join') {
                $result = $order->update(
                    [
                        'status' => 'accepted',
                    ]
                );
                $this->notificationService->acceptOrderNotification(Auth::user(), $order->playerId);
                if ($result == true) {

                    $otherOrder = Order::query()->where('playerId', $order->playerId)
                        ->where('id', '!=', $order->id)
                        ->where('coachId', '!=', Auth::id())
                        ->where('playerId', $order->playerId)
                        ->where('type', 'join')
                        ->where('status', 'waiting')->get();

                    foreach ($otherOrder as $item) {
                        $item->delete();
                    }
                    if ($otherOrder) {
                        return 'accepted successfully';
                    }
                }
            }
            if ($order->status == 'waiting' && $order->type == 'program') {
                $result = $order->update(
                    [
                        'status' => 'accepted',
                    ]
                );

                return 'accepted successfully';
            }
        }
    }

    public function requestProgram(Request $request) //as a player i want to request program from my coach
    {

        $Order = Order::query()->create(
            [
                'coachId' => $request->coachId,
                'playerId' => Auth::id(),
                'type' => $request->type,
            ]
        );
        return $Order;
    }

    public function getPremium($request)
    {

        $user = User::find(Auth::id());
        $program = $user->playerPrograms()
            ->where('type', 'private')->get()->toArray();
        return $program;
    }

    public function cancelOrder(Order $order)
    {

        if ($order->status == 'waiting') {
            $result = $order->delete();
            return $result;
        }

    }

    public function unAssign($user) // as a user i want to cancle join to my coach
    {
        $result = Order::query()->where('coachId', $user)->where('playerId', Auth::id())->where('type', 'join')->where('status', 'accepted')->delete();

        return $result;

    }

    public function deletePlayer($player) //as a coach i want to delete player from my player
    {

        $result = Order::query()->where('coachId', Auth::id())
            ->where('playerId', $player)
            ->where('type', 'join')
            ->where('status', 'accepted')
            ->delete();

        return $result;
    }

    public function showMyPlayer()
    {

        $order = Order::query()->where('coachId', Auth::id())
            ->where('status', 'accepted');
        $result = $order->with('player')->with('player.image', function ($query) {
            $query->where('type', null);
        })->get()->toArray();
        return $result;
    }

    public function myActivePlayer()
    {
        $order = Order::query()->where('coachId', Auth::id());

        $result = $order->where('status', 'accepted')
            ->where('type', 'join')
            ->whereHas('player', function ($query) {
                $query->whereHas('time', function ($query) {
                    $query->where('endTime', null);
                });
            })
            ->with('player')
            ->with('player.image')
            ->get()
            ->toArray();
        return $result;
    }
}
