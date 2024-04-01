<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\MonthService;
use App\Helpers\ResponseHelper;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    protected $userservice;
    protected $monthService;

    /**
     * Define the constructor to use the service.
     * @param UserService $userservice
     * @return none
     */
    public function __construct(
        UserService $userservice,
        MonthService $monthService
    ) {
        $this->userservice = $userservice;
        $this->monthService = $monthService;
    }

    /**
     * Return all available coaches.
     * @param none
     * @return ResponseHelper::array
     */
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

    /**
     * Return a specific coach info .
     * @param User $id
     * @return ResponseHelper::array
     */
    public function showCoachInfo($id)
    {
        try {
            $result = $this->userservice->coachinfo($id);
            return ResponseHelper::success($result, null, 'Coach info', 200);
        } catch (\Exception $e) {
            return ResponseHelper::error([], null, $e->getMessage(), 500);
        }
    }

    /**
     * Return all players .
     * @param none
     * @return ResponseHelper::array
     */
    public function showPlayer()
    {
        try {
            $result = $this->userservice->ShowPlayers();
            return ResponseHelper::success($result, null, 'All Players', 200);
        } catch (\Exception $e) {
            return ResponseHelper::error([], null, $e->getMessage(), 500);
        }
    }

    /**
     * Return a specific player info.
     * @param User $id
     * @return ResponseHelper::array
     */
    public function playerInfo($id)
    {
        try {
            $result = $this->userservice->playerinfo($id);
            return ResponseHelper::success($result, null, 'Player info', 200);
        } catch (\Exception $e) {
            return ResponseHelper::error([], null, $e->getMessage(), 500);
        }
    }

    /**
     * Edit a specific user details.
     * @param User $user
     * @param Request $request
     * @return UserService
     */
    public function updateUser(User $user, UpdateUserRequest $request)
    {
        try {
            return $this->userservice->UpdateUser($user, $request->toArray());
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Delete a specific user model.
     * @param User $user
     * @return UserService
     */
    public function deleteUser(User $user)
    {
        try {
            return $this->userservice->DeleteUser($user);
        } catch (\Exception $e) {
            return ResponseHelper::error([], null, $e->getMessage(), 500);
        }
    }

    /**
     * Get the financials of all players & coaches.
     * @param none
     * @return UserService
     */
    public function financial()
    {
        try {
            return $this->userservice->GetFinance();
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Check the subscriptions of all users.
     * @param none
     * @return UserService
     */
    public function subscription()
    {
        try {
            $results = $this->userservice->CheckSubscription();
            return ResponseHelper::success($results);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * renew the subscription of a user.
     * @param User $user
     * @return UserService
     */
    public function updateSubscription(User $user)
    {
        try {
            return $this->userservice->RenewSubscription($user);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * renew the subscription of a user.
     * @param User $user
     * @return UserService
     */
    public function showCountPercentage(User $user)
    {
        try {
            return $this->userservice->showCountPercentage($user);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Get financials for the previous 7 months.
     * @param none
     * @return ResponseHelper::array
     */
    public function financeMonth()
    {
        try {
            $previousMonths = $this->monthService->getPreviousMonths(7);
            $monthlyData = $this->userservice->financeMonth($previousMonths);
            return ResponseHelper::success($monthlyData);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Get the most rated coach.
     * @param none
     * @return UserService
     */
    public function mvpCoach()
    {
        try {
            return $this->userservice->MVPcoach();
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Search for a specific coach  by name.
     * @param Request $request
     * @return UserService
     */
    public function search(Request $request)
    {
        try {
            return $this->userservice->Search($request);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Get the number of expired players, coachs, reports.
     * @param none
     * @return UserService
     */
    public function statistics()
    {
        try {
            return $this->userservice->Statistics();
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Get the financials of the last year.
     * @param none
     * @return UserService
     */
    public function showAnnual()
    {
        try {
            return $this->userservice->Annual();
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Check if a player has a coach,who is the coach & get the food,sport programs .
     * @param none
     * @return UserService
     */
    public function info()
    {
        try {
            return $this->userservice->Info();
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }
}
