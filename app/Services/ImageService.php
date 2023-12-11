<?php

namespace App\Services;

use App\Models\Image;
use Auth;

class ImageService
{
    public function storeImage($request, $userId = null, $exerciseId = null, $path = '')
    {
        $request->validate([
            'image' => 'required|mimes:jpg,png',
        ]);

        $image = upload($request->image, $path);

        $result = Image::query()
        ->create([
            'userId' => $userId,
            'exerciseId' => $exerciseId,
            'image' => $image
        ]);

        return $result;
    }
}
