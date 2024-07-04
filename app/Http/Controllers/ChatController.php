<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function index()
    {
        // Optimized query to eager load relations and counts
        $chatRooms = ChatRoom::with('user')
            ->withCount('chatMessages')
            ->latest() // Shorter alias for orderBy('updated_at', 'desc')
            ->get(); // Fetch all chat rooms

        return Inertia::render('ChatRooms/Index', [
            'chatRooms' => $chatRooms->map(function ($chatRoom) {
                return [
                    'id' => $chatRoom->id,
                    'user' => $chatRoom->user, // Assumes you have a relationship defined
                    'chatMessagesCount' => $chatRoom->chat_messages_count, // The count field
                ];
            }),
        ]);
    }

    public function show(ChatRoom $chatRoom)
    {
        // Load the chat messages and eager load the associated user
        $chatRoom->load('chatMessages.user'); 

        return Inertia::render('ChatRooms/Show', [
            'chatRoom' => [
                'id' => $chatRoom->id,
                'user' => $chatRoom->user,
                'chatMessages' => $chatRoom->chatMessages->map(function ($message) {
                    return [
                        'id' => $message->id,
                        'user' => $message->user,
                        'message' => $message->message, // Or whatever your message content field is
                        'createdAt' => $message->created_at,
                    ];
                }),
            ],
            'authId' => auth()->id(),
        ]);
    }
}
