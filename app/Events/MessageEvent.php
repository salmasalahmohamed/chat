<?php

namespace App\Events;

use App\Models\Chat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageEvent implements  ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

 public  Chat  $chatData;
 public $user;
    /**
     * Create a new event instance.
     */
    public function __construct(  Chat $chatData)
    {
        $this->chatData=$chatData;
        $this->user=\Illuminate\Support\Facades\Auth::user();
    }

    public function broadcastWith(){
 return[
     'chat'=>$this->chatData
 ];
    }
//    public function broadcastAs(){
//        return'getChatMessage';
//    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('send-message'),
        ];
    }

}
