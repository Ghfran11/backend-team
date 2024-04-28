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
        $result = $this->imageService->storeImage($request, $request->user_id ?: Auth::id(), null, $request->type);
        return ResponseHelper::success($result);
    }

    public function storeExerciseImage(Request $request)
    {
        $result = $this->imageService->storeImage($request, null, $request->exerciseId);
        return ResponseHelper::success($result);
    }

    public function deleteUserImage(Request $request, $user)
    {
        $result = $this->imageService->deleteUserImage($user, $request->type);
        return ResponseHelper::success($result);
    }

    public function getImages(User $user)
    {
        $result = $user->images()->where('type', 'before')->orwhere('type', 'after')->get()->toArray();
        return ResponseHelper::success($result);
    }

    public function deleteAllUserImage(Request $request, $user)
    {
        $result = $this->imageService->deleteUserImage($user, $request->type);
        return ResponseHelper::success($result);
    }

    public function deleteOneImage($image)
    {
        $result = $this->imageService->deleteoneImage($image);
        return ResponseHelper::success($result);
    }

}
