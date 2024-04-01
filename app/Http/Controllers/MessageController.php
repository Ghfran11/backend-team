<?php

namespace App\Http\Controllers;

use App\Enum\NotificationType;
use App\Events\MessagesNotification;
use App\Helpers\ResponseHelper;
use App\Http\Requests\StoremessageRequest;
use App\Models\Message;
use App\Models\Message as ModelsMessage;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\MessageService;


class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     protected $messageService;

     public function __construct(MessageService $messageService)
     {
         $this->messageService = $messageService;

     }
    public function index() //TODO last message !!needs editing!!

    {
        try{
     $result=$this->messageService->index();
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoremessageRequest $request) //send message
    {
        try {
            $result=$this->messageService->store($request);
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user) //show chat with messages!!!!
    {
        try {
            $result=$this->messageService->show($user);
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModelsMessage $message) //delete message
    {
        try {
            $result=$this->messageService->destroy($message);
            return ResponseHelper::success($result);
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), $e->getCode());
        }
    }
}
