<?php

namespace App\Http\Controllers;

use App\Models\order;
use App\Http\Requests\StoreorderRequest;
use App\Http\Requests\UpdateorderRequest;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Order = Order::query()->get();
        return response($Order, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreorderRequest $request)
    {
        $Order = Order::query()->create(
            [
                'coachId' => $request->coachId,
                'playerId' => $request->playerId
            ]
        );
        return response($Order, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(order $order)
    {
        $result = $order->get();
        return response($result, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateorderRequest $request, order $order)
    {
        if ($order->status = 'waiting') {
            $order = Order::query()->update(
                [
                    'coachId' => $request->coachId,
                    'playerId' => $request->coachId
                ]
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(order $order)
    {
        if ($order->status = 'waiting') {
            $order->delete();
        }
    }
    public function getMyOrder()
    {
    }
}
