<?php

namespace App\Http\Controllers;

use App\Models\UserInfo;
use App\Models\User;
use App\Http\Requests\StoreUserInfoRequest;
use App\Http\Requests\UpdateUserInfoRequest;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class UserInfoController extends Controller
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
    public function store(StoreUserInfoRequest $request)
    {
        $userInfo=UserInfo::query()->create(
            [
                'gender'=>$request->gender,
                'weight'=>$request->weight,
                'waist Measurement'=>$request->waistMeasurement,
                'neck'=>$request->neck,
                'userId'=>Auth::id(),
                'height'=>$request->height,
                'birthDate'=>$request->birthDate
                ]
            );
            return ResponseHelper::success($userInfo);

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {

        $weight=$user->userInfo()->value('weight');
        $height=$user->userInfo()->value('height');
        $birthDate=$user->userInfo()->value('birthDate');
        $now = Carbon::now();
        $age=Carbon::parse($birthDate)->age;
        $BFP=$this->calculateBFP($weight,$height);

        $userInfo=$user->userInfo()->update(
            [
                'BFP'=>$BFP,
                'age'=> $age
            ]);
            $userInfo=$user->userInfo()->get()->toArray();



  return ResponseHelper::success($userInfo);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserInfoRequest $request)
    {
        $user=User::find(Auth::id());

        $userInfo=$user->userInfo()->update(
            [
                'gender'=>$request->gender,
                'weight'=>$request->weight,
                'waist Measurement'=>$request->waistMeasurement,
                'neck'=>$request->neck,
                'userId'=> Auth::id(),
                'height'=>$request->height,
                'birthDate'=>$request->birthDate
                ]
            );
            $result=$user->userInfo()->get()->toArray();

            return ResponseHelper::success($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserInfo $userInfo)
    {
        $userInfo->delete();

        return ResponseHelper::success(['message'=>'deleted successfuly']);
    }


    public function calculateBFP($weight, $height) {
        $W = $weight / 100; // convert weight to kg
        $H = $height / 100; // convert height to cm

        $BFP = 495 / (1.0324 - 0.19077 * log10($W) + 0.15456 * log10($H)) - 450;

        return round($BFP, 2); // round to 2 decimal places
     }
}

