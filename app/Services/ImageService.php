<?php


namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\Image;

class ImageService
{
    public function storeImage($request, $userId , $exerciseId = null, $type = null)
    {

        $images = $request->file('image');
        $result = [];
        foreach ($images as $image) {

            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/images'), $new_name);

            $existImage=Image::query()->where('userId',$userId)->where('type','profile')->get()->toArray();

            if($existImage && $type == null)
            {
                return 'you have profile Image';
            }
            else{

            $result[] = Image::query()->create([
                'userId' => $userId ? : (Auth::user()->id),
                'exerciseId' => $exerciseId,
                'image' => $new_name,
                'type' => $type
            ]);
        }
    }
        return $result;
    }
    // public function deleteUserImage($user)
    // {
    //     $result = Image::query()
    //     ->where('userId', $user->id)
    //     ->where(function ($query) {
    //         $query->where('type', 'before')
    //             ->orWhere('type', 'after');
    //     })
    //     ->delete();
    // }

    public function deleteUserImage($user, $type)
    {
        $result = Image::query()
            ->where('userId', $user)
            ->where('type', $type)
            ->delete();
        return $result;
    }
    public function deleteoneImage($image)
    {
        $image->delete();

    }
}
