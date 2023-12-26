<?php

namespace App\Http\Controllers;

use App\Enum\NotificationType;
use App\Events\MessagesNotification;
use App\Models\Notification;
use App\Helpers\ResponseHelper;
use App\Http\Requests\StoremessageRequest;
use Illuminate\Http\Response;
use App\Models\Message as ModelsMessage;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() //TODO last message !!needs editing!!
    {
        $list_chats = ModelsMessage::where('sender_id', Auth::id())
            ->orWhere('receiver_id', Auth::id())
            ->first();
        //->get();
        return response($list_chats, Response::HTTP_OK);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoremessageRequest $request) //send message
    {
        $message = ModelsMessage::query()->create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
        ]);
        $sender_name = Auth::user()->name;
        Notification::query()->create([
            'type' => NotificationType::MESSAGE,
            'receiver_id' => $request->receiver_id,
            'message_id' => $message->id,
        ]);
        event(new MessagesNotification($message, $sender_name));
        return response($message, Response::HTTP_CREATED);
    }
    /**
     * Display the specified resource.
     */
    public function show() //show chat with messages!!!!
    {
        $chat = ModelsMessage::where('sender_id', Auth::id())
            ->orWhere('receiver_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        return response($chat, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModelsMessage $message) //delete message
    {
        try {
            if ($message->sender_id != Auth::id()) {
                return response(Response::HTTP_UNAUTHORIZED);
            }
            $message->delete();
            return ResponseHelper::success('Message deleted successfully');
        } catch (\Exception $e) {
            return ResponseHelper::error([], null, $e->getMessage(), Response::HTTP_NOT_FOUND);
        }
    }
}
// public function show(User $user)
//     {
//         $userInfo=$user->userInfo()->get()->toArray();
//         $weight=$user->userInfo()->value('weight');
//         $height=$user->userInfo()->value('height');
//         $BFP=$this->calculateBFP($weight,$height);

//     }
