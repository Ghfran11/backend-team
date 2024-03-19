<?php


namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\Image;

class ImageService
{
    public function storeImage($request, $userId = null, $exerciseId = null, $type = null)
    {
        $images = $request->file('image');
        $result = [];
        foreach ($images as $image) {

            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/images'), $new_name);
            $result[] = Image::query()->create([
                'userId' => $exerciseId ? null : ($userId ?? Auth::user()->id),
                'exerciseId' => $exerciseId,
                'image' => $new_name,
                'type' => $type
            ]);
        }
        return $result;
    }
    public function deleteUserImage($user)
    {
        $result = Image::query()
        ->where('userId', $user->id)
        ->where(function ($query) {
            $query->where('type', 'before')
                ->orWhere('type', 'after');
        })
        ->delete();
    }
}
