<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Http\Requests\StoreChatRequest;
use App\Http\Requests\UpdateChatRequest;


class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() //chats list
    {
        $chats = Chat::where('sender_id', auth()->user()->id)
        ->orWhere('reciver_id', auth()->user()->id)
        ->get();
        return response()->json($chats);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChatRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Chat $chat)//chat messages
    {
        $chat = Chat::with('messages')
        ->where('sender_id', auth()->user()->id)
        ->orWhere('reciver_id', auth()->user()->id)
        ->first();
    return response()->json($chat);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChatRequest $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)//TODO!!!!!!!!!!!not neccerry
    {
        $chat = Chat::with('messages')
        ->where('sender_id', auth()->user()->id)
        ->orWhere('reciver_id', auth()->user()->id)
        ->first();
        $chat->delete();
        return response()->json('Deleted succesfully');
    }
}
