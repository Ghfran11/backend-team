<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Services\ImageService;
use App\Models\User;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{

    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function storeUserImage(Request $request)
    {
        try {

            $result = $this->imageService->storeImage($request, $request->user_id ?:Auth::id(), null, $request->type);
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function storeExerciseImage(Request $request)
    {
        try {
            $result = $this->imageService->storeImage($request, null, $request->exerciseId);
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    // public function deleteUserImage(Image $image)
    // {
    //     try {
    //         $result = $this->imageService->deleteUserImage($image);
    //         return ResponseHelper::success($result);
    //     } catch (\Exception $e) {
    //         return ResponseHelper::error($e->getMessage(), $e->getCode());
    //     }
    // }

    public function deleteUserImage(Request $request, $user)
    {
        try {
            $result = $this->imageService->deleteUserImage($user, $request->type);
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function getImages(User $user)
    {
        try {
            $result = $user->images()->where('type', 'before')->orwhere('type', 'after')->get()->toArray();
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }
    // public function deleteAllUserImage(User $user)
    // {
    //     try {
    //         $result = $this->imageService->deleteUserImage($user);
    //         return ResponseHelper::success($result);
    //     } catch (\Exception $e) {
    //         return ResponseHelper::error($e->getMessage(), $e->getCode());
    //     }
    // }
    public function deleteAllUserImage(Request $request, $user)
    {
        try {
            $result = $this->imageService->deleteUserImage($user, $request->type);
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }
    public function deleteOneImage(Image $image)
    {
        try {
            $result = $this->imageService->deleteoneImage($image);
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }

    }

}
