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
        foreach($request as $item)
        {
        $result[]= $this->imageService
        ->storeImage($item, Auth::user()->id, null, 'user/images');

        }
        return $result;
    }

    public function storeExerciseImage(Request $request)
    {
        foreach($request as $item)
        $result[] = $this->imageService
        ->storeImage($item, null, $request->exerciseId, 'exercise/images');

        return $result;
    }
}
