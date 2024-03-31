<?php

namespace App\Http\Controllers;

use App\Enum\NotificationType;
use App\Models\Notification;
use App\Models\order;
use App\Models\User;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreorderRequest;
use App\Http\Requests\UpdateorderRequest;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    public $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreorderRequest $request)
    {
        try {
            $existOrder = Order::where('playerId', Auth::id())
                ->where('coachId', $request->coachId)->exists();
            if ($existOrder) {
                return ResponseHelper::error('You already sent an order to this coach !');
            }
            $Order = Order::query()->create(
                [
                    'coachId' => $request->coachId,
                    'playerId' => Auth::id(),
                    'type' => 'join'
                ]
            );
            return ResponseHelper::success($Order);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(order $order)
    {
        try {
            $result = $order->get()->toArray();
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateorderRequest $request, order $order)
    {
        try {
            if ($order->status = 'waiting') {
                $order = Order::query()->update(
                    [
                        'coachId' => $request->coachId,
                        'playerId' => $request->playerId,
                    ]
                );
                return ResponseHelper::success($order);
            }
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(order $order)
    {
        try {
            if ($order->status = 'waiting') {
                $order->delete();
            }
            return ResponseHelper::success(['deleted successfully']);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function getMyOrder(Request $request)
    {
        try {
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
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function acceptOrder(Order $order)
    {
        try {
            if ($order->coachId == Auth::id()) {

                if ($order->status == 'waiting' && $order->type == 'join') {
                    $result = $order->update(
                        [
                            'status' => 'accepted',
                        ]
                    );

                    if ($result == true) {
                        $this->notificationService->acceptOrderNotification(Auth::user(), $order->playerId);
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
                            return ResponseHelper::success([], null, 'accepted successfully', 200);
                        }
                    }
                }
                if ($order->status == 'waiting' && $order->type == 'program') {
                    $result = $order->update(
                        [
                            'status' => 'accepted',
                        ]
                    );

                    return ResponseHelper::success([], null, 'accepted successfully', 200);
                }
            }

        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }


    public function requestProgram(Request $request)
    {
        try {
            $Order = Order::query()->create(
                [
                    'coachId' => $request->coachId,
                    'playerId' => Auth::id(),
                    'type' => $request->type
                ]
            );
            return ResponseHelper::success($Order);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function getPremium(Request $request)
    {
        try {
            $user = User::find(Auth::id());
            $program = $user->playerPrograms()
                ->where('type', $request->type)->get()->toArray();
            return ResponseHelper::success($program);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function cancelOrder(Order $order)
    {
        try {
            if ($order->status == 'waiting') {
                $result = $order->delete();
                return ResponseHelper::success($result, 'canceled successfully');
            }
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function unAssign($user)
    {
        try {

            $result = Order::query()->where('coachId', $user)->where('playerId', Auth::id())->where('type', 'join')->where('status', 'accepted')->delete();


            return ResponseHelper::success($result, 'canceled successfully');

        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function deletePlayer($player)
    {
        try {
            $result = Order::query()->where('coachId', Auth::id())->where('playerId', $player)->where('type', 'join')->where('status', 'accepted')->delete();

            return ResponseHelper::success($result, 'canceled successfully');

        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function showMyPlayer()//as a coach i want to show my accepted players
    {
        try {
            $order = Order::query()->where('coachId', Auth::id())
                ->where('status', 'accepted');
            $result = $order->with('player')->with('player.image', function ($query) {
                $query->where('type', null);
            })->get()->toArray();
            return ResponseHelper::success($result, 'your player');
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function myActivePlayer()
    {
        try {
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
            return ResponseHelper::success($result, 'your  active player');


        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }
}

