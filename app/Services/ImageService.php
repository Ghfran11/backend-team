<?php

namespace App\Services;

use App\Models\Image;
use Auth;

class ImageService
{
    public function storeImage($image, $userId = null, $exerciseId = null, $path = '')
    {
        $images = uploadArray([$image], $path);

        $result = Image::query()
            ->create([
                'userId' => $userId,
                'exerciseId' => $exerciseId,
                'image' => $images[0]
            ]);

        return $result;
    }
}
