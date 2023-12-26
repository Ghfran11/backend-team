<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\User;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showCoach()
    {
        try {
            $result = User::query()
                ->where('role', 'coach')
                ->with('image')
                ->get()
                ->toArray();

            if (empty($result)) {
                return ResponseHelper::error([], null, 'No coaches found', 204);
            }

            return ResponseHelper::success($result, null, 'Show Coaches', 200);
        } catch (\Exception $e) {
            return ResponseHelper::error([], null, $e->getMessage(), 500);
        }
    }

    public function showCoachInfo(Request $request)
    {

        $result=User::query()
        ->where('id', $request->id)
        ->where('role','coach')
        ->with('image')->get()->toArray();

        return ResponseHelper::success($result);


        try {
            $result = User::query()
                ->where('id', $request->id)
                ->where('role', 'coach')
                ->with('image')
                ->get()
                ->toArray();
            if (empty($result)) {
                return ResponseHelper::error([], null, 'Coach not found', 404);
            }
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error([], null, $e->getMessage(), 500);
        }

    }

    public function showPlayer()
    {
        try {
            $result = User::query()
                ->where('role', 'player')
                ->with('image')
                ->get()
                ->toArray();
            if (empty($result)) {
                return ResponseHelper::error([], null, 'No players found', 204);
            }
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error([], null, $e->getMessage(), 500);
        }
    }

    public function playerInfo(Request $request)
{
    try {
        $result = User::query()
            ->where('id', $request->id)
            ->where('role', 'player')
            ->with('image')
            ->get();
        if ($result->isEmpty()) {
            return ResponseHelper::error([], null, 'User not found', 404);
        }
        return ResponseHelper::success($result);
    } catch (\Exception $e) {
        return ResponseHelper::error([], null, $e->getMessage(), 500);
    }
}
    public function updateUser(User $user, Request $request)
    {
        $user->update(
            [
                'name' => $request->name,
                'birthDate'=>$request->birthDate,
                'phoneNumber'=>$request->phoneNumber,
                'role'=>$request->role,
                'finance'=>$request->finance


            ]

            );

            return ResponseHelper::success(['updated successfuly']);
    }
    public function deleteUser(User $user)
    {
        try {
            $result = $user->delete();

            if ($result) {
                return ResponseHelper::success(['message' => 'User deleted successfully']);
            } else {
                return ResponseHelper::error([], null, 'Failed to delete user', 500);
            }
        } catch (\Exception $e) {
            return ResponseHelper::error([], null, $e->getMessage(), 500);
        }

    }


    public function financial()
    {
        $payments=User::query()->where('role','coach')->sum('finance');
        $Imports=User::query()->where('role','player')->sum('finance');
        return ResponseHelper::success([
            'payments'=>$payments,
            'Imports'=>$Imports
        ]);



    }
    public function Subscription()
    {
        $users=User::query()->where('role','player')->get()->toArray();
        foreach($users as $user)
        {
        $userName=$user['name'];
        $expiration = \Carbon\Carbon::parse($user['expiration']);
         $now = \Carbon\Carbon::now();
         $remainingTime = $now->diffInDays($expiration, false);
         if($remainingTime < 0 )
         {
            $daysNotPaid=abs($remainingTime);
         }
         else{
            $daysNotPaid=null;

         }
         $SubscriptionDate=$expiration->subMonth();
         $Paid=$user['is_paid'];
         $result=[
         'userNaname'=>$userName,
         'remainingTime'=> $remainingTime,
         'paidStatus'=>$Paid,
         'SubscriptionDate'=> $SubscriptionDate,
         'daysNotPaid'=> $daysNotPaid,
         ];
         $results[] = $result;
        }
         return ResponseHelper::success($results);


    }
         public function updateSubscription(User $user, Request $request)
         {
            if($user->is_paid == 'unpaid')
            {
            $user->update(
        [
            'expiration'=>now()->addMonth(),
            'finance'=>$request->subscriptionFee
        ]);
        return ResponseHelper::success('updated successfully');
    }
    else
    {
        return ResponseHelper::success('this user was paid');

    }

 }



    }

