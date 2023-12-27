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
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() //TODO last message !!needs editing!!
    {
        $user = User::find(Auth::id());
        $messages = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->get();

        $chats = $messages->groupBy(function ($message) use ($user) {
            return $message->sender_id == $user->id ? $message->receiver_id : $message->sender_id;
        });

        $chatDetails = [];

        foreach ($chats as $chatId => $messages) {
            $sid2 = User::find($chatId);
            $latestMessage = $messages->sortByDesc('created_at')->first();
            $chatDetails[] = [
                'sid2' => $sid2,
                'latestMessage' => $latestMessage,
            ];
        }

        return response($chatDetails, Response::HTTP_OK);
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
    public function show(User $user) //show chat with messages!!!!
    {

        $chat = Message::query()->where([
            ['sender_id', $user->id],
            ['receiver_id', Auth::id()],
        ])->orWhere([
            ['sender_id', Auth::id()],
            ['receiver_id', $user->id],
        ])->get();
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
