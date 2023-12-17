<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showCoach()
    {
        $result=User::query()
        ->where('role','coach')->get();
        return ResponseHelper::success($result);

    }

    public function showCoachInfo( User $user)
    {
        //الكود ما عطى نتيجة صح هون او ما اعطى اي نتيجة
        // $result=User::query()->where('id',$request->id)
        // ->where('role','coach')->with('image')->get();
        $result['coach']=$user;
        $result['images']=$user->image()->get();
        return ResponseHelper::success($result);

    }

    public function showPlayer( )
    {
        $result=User::query()
        ->where('role','player')->get();
        return ResponseHelper::success($result);

    }

    public function playerInfo( User $user)
    {
        //كمان نفس قصة الكوتش عم يجيب مصفوفة الصور فاضية
        // $result=User::query()
        // ->where('id',$request->id)
        // ->where('role','player')->with('image')->get();

        $result['player']=$user;
        $result['images']=$user->image()->get();
        return ResponseHelper::success($result);

    }
}
