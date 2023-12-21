<?php

namespace App\Http\Controllers;

use App\Enum\NotificationType;
use App\Events\MessagesNotification;
use App\Models\message;
use App\Models\Notification;
use App\Helpers\ResponseHelper;
use App\Http\Requests\StoremessageRequest;
use App\Http\Requests\UpdatemessageRequest;
use App\Models\Chat;
use Illuminate\Http\Response;
use App\Models\Message as ModelsMessage;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() //show chat!!!!
    {
        // $chat = Message::where('sender_id', auth()->user()->id)
        //     ->orWhere('reciver_id', auth()->user()->id)
        //     ->orderBy('created_at', 'desc')
        //     ->get();
        // return response($chat, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoremessageRequest $request) //send message
    {
        $chat = Chat::query()->updateOrCreate([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,

        ]);
        $message = $chat->messages()->create(
            [
                'content' => $request->content,
            ]
        );
        $sender_name = Auth::user()->name;
        event(new MessagesNotification($message, $sender_name));
        Notification::create([
            'type' => NotificationType::MESSAGE,
            'receiver_id' => $chat->receiver_id,
            'message_id' => $message->id,
        ]);
        return response($message, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatemessageRequest $request, message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(message $message) //delete message
    {
        if ($message->sender_id != Auth::id()) {
            return response(Response::HTTP_UNAUTHORIZED);
        }
        $message->delete();
        return ResponseHelper::success('Message deleted successfully');
    }
}
