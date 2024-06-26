<?php


namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\Image;
use App\Models\User;

class ImageService
{
    public function storeImage($request, $userId, $exerciseId = null, $type)
    {
        $images = $request->file('image');
        $result = [];
        foreach ($images as $image) {
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/images'), $new_name);
            $existImage = Image::query()->where('userId', $userId)
                ->where('type', 'profile')->get()->toArray();
            if ($existImage && $type == null) {
                return 'you have profile Image';
            } else {
                $result[] = Image::query()->create([
                    'userId' => $userId ?: (Auth::id()),
                    'exerciseId' => $exerciseId,
                    'image' => $new_name,
                    'type' => $type
                ]);
            }
        }
        return $result;
    }

    public function deleteUserImage($user, $type)
    {
        $userId = User::find($user);
        if ($userId) {
            $result = Image::query()
                ->where('userId', $userId->id)
                ->where('type', $type)
                ->delete();
            if ($result) {
                return $result;
            }
        }
        return false;
    }


    public function deleteoneImage($image_id)
    {
        $image = Image::findOrFail($image_id);
        $result = $image->delete();
        return $result;
    }
}
