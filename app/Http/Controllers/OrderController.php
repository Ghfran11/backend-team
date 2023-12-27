<?php

namespace App\Http\Controllers;

use App\Models\order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreorderRequest;
use App\Http\Requests\UpdateorderRequest;
use Illuminate\Http\Response;
use App\Helpers\ResponseHelper;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreorderRequest $request)
    {
        $Order = Order::query()->create(
            [
                'coachId'=>$request->coachId,
                'playerId'=>Auth::id(),


            ]
            );
            return ResponseHelper::success($Order);



    }

    /**
     * Display the specified resource.
     */
    public function show(order $order)
    {
        $result=$order->get()->toArray();
        return ResponseHelper::success($result);



    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateorderRequest $request, order $order)
    {
       if($order->status = 'waiting')
       {
        $order=Order::query()->update(
            [
                'coachId'=>$request->coachId,
                'playerId'=>$request->coachId,

            ]
            );
            return ResponseHelper::success($order);

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

        return ResponseHelper::success(['deleted succesfully']);
    }
    public function getMyOrder()
    {


        $user=User::find(Auth::id());

        if( $user->role == 'coach')
        {
        $result=$user->coachOrder()->get()->toArray();
        }
        else if( $user->role == 'player')
        {

            $result=$user->playerOrder()->get()->toArray();

        }

        return ResponseHelper::success($result);


    }
    public function acceptOrder(Order $order)
    {
        if($order->status= 'waiting')
        {
       $result= $order->update(
            [
                'status'=>'accepted',
            ]
            );

            $otherOrder=Order::query()->where('playerId',$order->playerId)->where('coachId','!=',Auth::id())->delete();;



        }
        return ResponseHelper::success($result);


    }
}
