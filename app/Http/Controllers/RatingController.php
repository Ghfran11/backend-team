<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function setRate(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'rate' => 'required|numeric|between:1,5',
            ]);
            Rating::query()
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
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }
    public function deleteRate(Request $request)
    {
        try {
            Rating::query()
                ->where('id', $request->id)
                ->delete();
            return ResponseHelper::success('success');
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }
}
