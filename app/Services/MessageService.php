<?php

namespace App\Services;

use App\Events\MessagesNotification;
use App\Helpers\ResponseHelper;
use App\Models\Message;
use App\Models\Message as ModelsMessage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessageService
{
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
            $sid2->image;
            $latestMessage = $messages->sortByDesc('created_at')->first();
            $chatDetails[] = [
                'sid2' => $sid2,
                'latestMessage' => $latestMessage,

            ];
        }
        return $chatDetails;

    }

/**
 * Store a newly created resource in storage.
 */
    public function store($request) //send message
    {
        $message = ModelsMessage::query()->create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
        ]);
        $sender_name = Auth::user()->name;
        // Notification::query()->create([
        //     'type' => NotificationType::MESSAGE,
        //     'receiver_id' => $request->receiver_id,
        //     'message_id' => $message->id,
        // ]);
        event(new MessagesNotification($message, $sender_name));
        return $message;

    }

/**
 * Display the specified resource.
 */
    public function show(User $user) //show chat with messages!!!!
    {
        $message = Message::query()->where([
            ['sender_id', $user->id],
            ['receiver_id', Auth::id()],
        ])->orWhere([
            ['sender_id', Auth::id()],
            ['receiver_id', $user->id],
        ])->get();
        foreach ($message as $item) {
            if ($item->sender_id == Auth::id()) {
                $is_sender = true;
            } else {
                $is_sender = false;
            }
            $results[] =
                [
                'id' => $item->id,
                'sender_id' => $item->sender_id,
                'receiver_id' => $item->receiver_id,
                'content' => $item->content,
                'is_sender' => $is_sender,
                'created_at' => $item->created_at,
            ];
        }
        return $results;

    }

/**
 * Remove the specified resource from storage.
 */
    public function destroy(ModelsMessage $message) //delete message
    {

        if ($message->sender_id != Auth::id()) {
            return ResponseHelper::error('unauthorized');
        }
        $message->delete();
        return 'Message deleted successfully';

    }
}
