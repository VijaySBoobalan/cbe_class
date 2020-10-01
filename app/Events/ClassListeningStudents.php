<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ClassListeningStudents implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $student_id;
    public $schedule_id;
    public $student_name;
    public $status;
    public function __construct($student_details)
    {
		 $this->student_id  = $student_details['student_id'];
		 $this->schedule_id  = $student_details['schedule_id'];
         $this->student_name  = $student_details['student_name'];
         $this->status  = $student_details['status'];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('class-listening');
    }
	public function broadcastAs(){
		return "class-listening-event";
	}
}
