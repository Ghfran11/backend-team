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
        $result = $this->messageService->index();
        return ResponseHelper::success($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoremessageRequest $request) //send message
    {
        $result = $this->messageService->store($request);
        return ResponseHelper::success($result);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user) //show chat with messages!!!!
    {
        $result = $this->messageService->show($user);
        return ResponseHelper::success($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModelsMessage $message) //delete message
    {
        $result = $this->messageService->destroy($message);
        return ResponseHelper::success($result);
    }
}
