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
        ->where('role','coach')->with('image')->get()->toArray();
        return ResponseHelper::success($result);

    }

    public function showCoachInfo(Request $request)
    {
        //الكود ما عطى نتيجة صح هون او ما اعطى اي نتيجة
        $result=User::query()
        ->where('id', $request->id)
        ->where('role','coach')
        ->with('image')->get()->toArray();

        return ResponseHelper::success($result);

    }

    public function showPlayer( )
    {
        $result=User::query()
        ->where('role','player')->get()->toArray();
        return ResponseHelper::success($result);

    }

    public function playerInfo(Request $request)
    {

        $result=User::query()
        ->where('id', $request->id)
        ->where('role','player')
        ->with('image')->get();

        return ResponseHelper::success($result);

    }
    public function updateUser(User $user, Request $request)
    {
        $user->update(
            [
                'name' => $request->name,
                'birthDate'=>$request->birthDate,
                'phoneNumber'=>$request->phoneNumber,
                'role'=>$request->role,

            ]

            );
            $result=$user->get();
            return ResponseHelper::success($result);


    }
    public function deleteUser(User $user)
    {
        $result=$user->delete();

        return ResponseHelper::success(
            [

                'message' => 'user deleted successfully'
            ]
        );

    }

}
