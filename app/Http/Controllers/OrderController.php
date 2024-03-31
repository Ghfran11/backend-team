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


    public function __construct(OrderService $orderService,NotificationService $notificationService)
    {
        $this->orderService = $orderService;
        $this->notificationService = $notificationService;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreorderRequest $request)
    {
        try {
            $order = $this->orderService->store($request);

            return ResponseHelper::success($order);
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
            $order = $this->orderService->show($order);
            return ResponseHelper::success($order);
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
            $order = $this->orderService->update($request, $order);

            return ResponseHelper::success($order);

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
            $order = $this->orderService->destroy($order);
            return ResponseHelper::success(['deleted successfully']);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function getMyOrder(Request $request)
    {
        try {
            $order = $this->orderService->getMyOrder($request);
            return ResponseHelper::success($order);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function acceptOrder(Order $order)
    {
        try {
            $order = $this->orderService->acceptOrder($order);

            return ResponseHelper::success([], null, 'accepted successfully', 200);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function requestProgram(Request $request)
    {
        try {
            $order = $this->orderService->store($request);
            return ResponseHelper::success($order);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function getPremium(Request $request)
    {
        try {
            $program=$this->orderService->getPremium($request);
            return ResponseHelper::success($program);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function cancelOrder(Order $order)
    {
        try {
            $result = $this->orderService->cancelOrder($order);

            return ResponseHelper::success($result, 'canceled successfully');

        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function unAssign($user)
    {
        try {

            $result = $this->orderService->unAssign($user);
            return ResponseHelper::success($result, 'canceled successfully');

        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function deletePlayer($player)
    {
        try {
            $result = $this->orderService->deletePlayer($player);

            return ResponseHelper::success($result, 'canceled successfully');

        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function showMyPlayer()
    {
        try {
            $result = $this->orderService->showMyPlayer();
            return ResponseHelper::success($result, 'your player');
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function myActivePlayer()
    {
        try {
            $result = $this->orderService->myActivePlayer();
            return ResponseHelper::success($result, 'your  active player');

        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }
}
