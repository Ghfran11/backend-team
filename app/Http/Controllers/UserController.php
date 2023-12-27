<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
                'birthDate' => $request->birthDate,
                'phoneNumber' => $request->phoneNumber,
                'role' => $request->role,

            ]

        );
        $result = $user->get();
        return ResponseHelper::success($result);
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

    public function search(Request $request)
    {
        $search = $request->input('search_text');
        $oppositeRole = Auth::user()->role == 'player' ? 'coach' : 'player';
        $users = User::query()
            ->when(in_array(Auth::user()->role, ['player', 'coach']), function ($query) use ($oppositeRole) {
                return $query->where('role', $oppositeRole);
            })
            ->where('name', 'LIKE', "%{$search}%")
            ->get();
        return ResponseHelper::success($users);
    }
}
