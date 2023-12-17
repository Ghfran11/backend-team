<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showCoach( Request $request)
    {
        $result=User::query()
        ->where('type','coach')->get();
        return ResponseHelper::success($result);

    }

    public function showCoachInfo( Request $request)
    {
        $result=User::query()->where('id',$request->id)
        ->where('type','coach')->with('image')->get();
        return ResponseHelper::success($result);

    }

    public function showPlayer( Request $request)
    {
        $result=User::query()
        ->where('type','player')->get();
        return ResponseHelper::success($result);

    }

    public function playerInfo( Request $request)
    {
        $result=User::query()
        ->where('id',$request->id)
        ->where('type','player')->with('image')->get();
        return ResponseHelper::success($result);

    }
}
