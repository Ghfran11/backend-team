<?php

namespace App\Http\Controllers;

use App\Services\ImageService;
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
        $result = $this->imageService->storeImage($request, Auth::user()->id, null);
        return $result;
    }

    public function storeExerciseImage(Request $request)
    {
        $result = $this->imageService->storeImage($request, null, $request->exerciseId);
        return $result;
    }
}
