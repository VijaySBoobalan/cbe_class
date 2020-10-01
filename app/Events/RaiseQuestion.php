<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RaiseQuestion implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $user_name;
    public $message;
    public $user_id;
    public $staff_id;
   
    public function __construct($user_details)
    {
        $this->user_name  = $user_details['user_name'];
        $this->message  = $user_details['message'];
        $this->user_id  = $user_details['user_id'];
        $this->staff_id = $user_details['staff_id'];
    }

    public function broadcastOn()
    {
        return new Channel('raise-question');
		
    }
	public function broadcastAs(){
		return "raise-question-event";
	}
}
