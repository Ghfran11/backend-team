<?php

namespace App\Http\Traits;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait Files
{
    public static function saveFile(Request $request)
    {
        $file = $request->file('file');
        $theFilePath = null;
        if ($request->hasFile('file')) {
            $theFilePath = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/programs'), $theFilePath);
        }
        return $theFilePath;
    }

    public static function deleteFile($file)
    {
        Storage::delete($file);
    }

    public static function saveImage(Request $request)
    {
        $file = $request->file('imageUrl');
        $theFilePath = null;
        if ($request->hasFile('imageUrl')) {
            $theFilePath = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/images'), $theFilePath);
        }
        return $theFilePath;
    }
}
