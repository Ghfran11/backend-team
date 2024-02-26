<?php

namespace App\Http\Controllers;

use App\Models\order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreorderRequest;
use App\Http\Requests\UpdateorderRequest;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;


class OrderController extends Controller
{
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

    public function getMyOrder()
    {
        try {
            $user = User::find(Auth::id());
            if ($user->role = 'coach') {
                $result = $user->coachOrder()->get()->toArray();
            } else if ($user->role = 'player') {
                $result = $user->playerOrder()->get()->toArray();
            }
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function acceptOrder(Order $order)
    {
        try {
            if ($order->status == 'waiting' && $order->type == 'join') {
                $result = $order->update(
                    [
                        'status' => 'accepted',
                    ]
                );
                if ($result) {
                    $otherOrder = Order::query()->where('playerId', $order->playerId)
                        ->where('id', '!=', $order->id)
                        ->where('coachId', '!=', Auth::id())
                        ->where('type', 'join')
                        ->where('status', 'waiting')->delete();
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
                if ($result) {
                    return ResponseHelper::success([], null, 'accepted successfully', 200);
                }
            } else {
                return ResponseHelper::success([], null, 'Not accepted', 200);
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
                    'type' => 'program'
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

    public function unAssign(Order $order)
    {
        try {
            if ($order->status == 'accepted') {
                $result = $order->delete();
                return ResponseHelper::success($result, 'canceled successfully');
            }
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function showMyPlayer()
    {
        try {
            $order = Order::query()->where('coachId', 12);
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
            $order = Order::query()->where('coachId', 12);
            $result = $order->with('player')->with('player.image', function ($query) {
                $query->where('type', null);
            })->with('player.time', function ($query) {
                $query->where('endTime', null);
            })->get()->toArray();
            return ResponseHelper::success($result, 'your  active player');
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }
}
