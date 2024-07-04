<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserSentChatMessageEvent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
 
    public function __construct(public ChatMessage $chatMessage)
    {
        $this->chatMessage->load(['chatRoom', 'user']);
    }
 
    public function broadcastOn()
    {
        return [
            new PrivateChannel('userRepliedToChatRoom.' . $this->chatMessage->chatRoom->id),
        ];
    }
}
