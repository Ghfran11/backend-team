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
use App\Services\ImageService;

class UserInfoController extends Controller
{

    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserInfoRequest $request)
    {
        try {
            $userInfo = UserInfo::query()->create(
                [
                    'gender' => $request->gender,
                    'weight' => $request->weight,
                    'waist Measurement' => $request->waistMeasurement,
                    'neck' => $request->neck,
                    'userId' => Auth::id(),
                    'height' => $request->height,
                    'birthDate' => $request->birthDate
                ]
            );
            return ResponseHelper::success($userInfo);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        try {
            $weight = $user->userInfo()->value('weight');
            $height = $user->userInfo()->value('height');
            $birthDate = $user->userInfo()->value('birthDate');
            $age = Carbon::parse($birthDate)->age;
            $BFP = $this->calculateBFP($weight, $height);
            $userInfo = $user->userInfo()->update(
                [
                    'BFP' => $BFP,
                    'age' => $age
                ]
            );
            $userInfo = $user->userInfo()->get()->toArray();
            return ResponseHelper::success($userInfo);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserInfoRequest $request)
    {
        try {
            $user = User::find(Auth::id());
            $userInfo = $user->userInfo()->updateOrcreate(
                [
                    'gender' => $request->gender,
                    'weight' => $request->weight,
                    'waist Measurement' => $request->waistMeasurement,
                    'neck' => $request->neck,
                    'userId' => Auth::id(),
                    'height' => $request->height,
                    'birthDate' => $request->birthDate
                ]
            );
            if ($request->has('image')) {
                $this->imageService->storeImage($request, Auth::id(), null, 'profile');
            }
            return ResponseHelper::success($userInfo);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserInfo $userInfo)
    {
        try {
            $userInfo->delete();
            return ResponseHelper::success(['message' => 'deleted successfuly']);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function calculateBFP($weight, $height)
    {
        try {
            $W = $weight / 100; // convert weight to kg
            $H = $height / 100; // convert height to cm
            $BFP = 495 / (1.0324 - 0.19077 * log10($W) + 0.15456 * log10($H)) - 450;
            return round($BFP, 2); // round to 2 decimal places
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }
}

