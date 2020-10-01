<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LiveChats implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
	
	public $session_id;
   
    public function __construct($live_chat_details)
    {
        $this->session_id  = $live_chat_details->session_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('live-chat');
    }
	public function broadcastAs(){
		return "live-chat-event";
	}
}
