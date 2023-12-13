<?php

namespace App\Http\Controllers;

use App\Services\ImageService;
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
        $result = $this->imageService
        ->storeImage($request->image, Auth::user()->id, null, 'user/images');

        return $result;
    }


    public function storeExerciseImage(Request $request)
    {
        $result = [];

        if ($request->hasFile('image')) {
            $image = $request->image;
            $result = $this->imageService
            ->storeImage($image, null, $request->exerciseId, 'exercise/images');
        }

        return $result;
    }
}


