<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Onlineclass implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
	
	public $username;
    public $message;
    public $session_id;
    public $broadcastToclass;
    public $broadcastTosection;
    public $count;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($post)
    {
		$username=$post['staff_name'];
        $this->username = $username ."";
        $this->message  = "onlive";
        $this->session_id  = $post['session_id'];
        $this->broadcastToclass  = $post['class_id'];
        $this->broadcastTosection  = $post['section_id'];
        $this->count  = $post['count'];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
  
	public function broadcastOn()
    {
        return new Channel('online-class');
		// return ['online-class'];
    }
	public function broadcastAs(){
		return "class-event";
	}
}
