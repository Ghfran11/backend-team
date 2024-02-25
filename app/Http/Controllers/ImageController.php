<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Services\ImageService;
use App\Models\User;
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
            $result = $this->imageService->storeImage($request, Auth::id(), null, $request->type);
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

    public function deleteUserImage(Request $request)
    {
        try {
            $result = $this->imageService->storeImage($request, Auth::id(), null);
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    public function getImages(User $user)
    {
        try {
            $result = $user->image()->where('type', 'before')->orwhere('type', 'after')->get();
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }
}
