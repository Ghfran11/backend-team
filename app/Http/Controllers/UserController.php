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
        UserService  $userservice,
        MonthService $monthService
    )
    {
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
            $result = $this->userservice->coachinfo($id);
            return ResponseHelper::success($result, null, 'Coach info', 200);
    }

    /**
     * Return all players .
     * @param none
     * @return ResponseHelper::array
     */
    public function showPlayer()
    {
        $result = $this->userservice->ShowPlayers();
        return ResponseHelper::success($result, null, 'All Players', 200);
    }

    /**
     * Return a specific player info.
     * @param User $id
     * @return ResponseHelper::array
     */
    public function playerInfo($id)
    {
        $result = $this->userservice->playerinfo($id);
        return ResponseHelper::success($result, null, 'Player info', 200);
    }

    /**
     * Edit a specific user details.
     * @param User $user
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function updateUser(User $user, UpdateUserRequest $request)
    {
        return $this->userservice->UpdateUser($user, $request->toArray());
    }

    /**
     * Delete a specific user model.
     * @param User $user
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function deleteUser(User $user)
    {
        return $this->userservice->DeleteUser($user);
    }

    /**
     * Get the financials of all players & coaches.
     * @param none
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function financial()
    {
        return $this->userservice->GetFinance();
    }

    /**
     * Check the subscriptions of all users.
     * @param none
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function subscription()
    {
        $results = $this->userservice->CheckSubscription();
        return ResponseHelper::success($results);
    }

    /**
     * renew the subscription of a user.
     * @param User $user
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function updateSubscription(User $user,Request $request)
    {
        return $this->userservice->RenewSubscription($user,$request);
    }

    /**
     * renew the subscription of a user.
     * @param User $user
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function showCountPercentage(User $user)
    {
        return $this->userservice->showCountPercentage($user);
    }

    /**
     * Get financials for the previous 7 months.
     * @param none
     * @return ResponseHelper::array
     */
    public function financeMonth()
    {
        $previousMonths = $this->monthService->getPreviousMonths(7);
        $monthlyData = $this->userservice->financeMonth($previousMonths);
        return ResponseHelper::success($monthlyData);
    }

    /**
     * Get the most rated coach.
     * @param none
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function mvpCoach()
    {
        return $this->userservice->MVPcoach();
    }

    /**
     * Search for a specific coach  by name.
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        return $this->userservice->Search($request);
    }

    /**
     * Get the number of expired players, coachs, reports.
     * @param none
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function statistics()
    {
        return $this->userservice->Statistics();
    }

    /**
     * Get the financials of the last year.
     * @param none
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function showAnnual()
    {
        return $this->userservice->Annual();
    }

    /**
     * Check if a player has a coach,who is the coach & get the food,sport programs .
     * @param none
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function info()
    {
        return $this->userservice->Info();
    }
}
