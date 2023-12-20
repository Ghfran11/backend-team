<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function setRate(Request $request)
{
    $validatedData = $request->validate([
        'rate' => 'required|numeric|between:1,5',
    ]);

    $result = Rating::query()
        ->updateOrCreate(
            [
                'playerId' => Auth::user()->id,
                'coachId' => $request->coachId,
            ],
            [
                'rate' => $validatedData['rate'],
            ]
        );

    return ResponseHelper::success('Rate set successfully');
}
    public function deleteRate(Request $request){


        $result = Rating::query()
        ->where('id',$request->id)
        ->delete();
        return ResponseHelper::success('success');

    }




}
