<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreorderRequest;
use App\Http\Requests\UpdateorderRequest;
use App\Models\order;
use App\Services\NotificationService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    protected $orderService;
    public $notificationService;


    public function __construct(OrderService $orderService, NotificationService $notificationService)
    {
        $this->orderService = $orderService;
        $this->notificationService = $notificationService;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreorderRequest $request)
    {
        $order = $this->orderService->store($request);
        return ResponseHelper::success($order);
    }

    /**
     * Display the specified resource.
     */
    public function show(order $order)
    {
        $order = $this->orderService->show($order);
        return ResponseHelper::success($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateorderRequest $request, order $order)
    {
        $order = $this->orderService->update($request, $order);
        return ResponseHelper::success($order);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(order $order)
    {
        $this->orderService->destroy($order);
        return ResponseHelper::success(['deleted successfully']);

    }

    public function getMyOrder(Request $request)
    {
        $order = $this->orderService->getMyOrder($request);
        return ResponseHelper::success($order);
    }

    public function acceptOrder(Order $order)
    {
        $this->orderService->acceptOrder($order);
        return ResponseHelper::success([], null, 'accepted successfully', 200);
    }

    public function requestProgram(Request $request)
    {
        $order = $this->orderService->store($request);
        return ResponseHelper::success($order);
    }

    public function getPremium(Request $request)
    {
        $program = $this->orderService->getPremium($request);
        return ResponseHelper::success($program);
    }

    public function cancelOrder(Order $order)
    {
        $result = $this->orderService->cancelOrder($order);
        return ResponseHelper::success($result, 'canceled successfully');
    }

    public function unAssign($user)
    {
        $result = $this->orderService->unAssign($user);
        return ResponseHelper::success($result, 'canceled successfully');
    }

    public function deletePlayer($player)
    {
        $result = $this->orderService->deletePlayer($player);
        return ResponseHelper::success($result, 'canceled successfully');
    }

    public function showMyPlayer()
    {
        $result = $this->orderService->showMyPlayer();
        return ResponseHelper::success($result, 'your player');
    }

    public function myActivePlayer()
    {
        $result = $this->orderService->myActivePlayer();
        return ResponseHelper::success($result, 'your  active player');
    }
}
