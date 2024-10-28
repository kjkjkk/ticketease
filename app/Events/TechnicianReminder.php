<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class TechnicianReminder implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // public $result ;
    public $user ;
    public function __construct( User $user ){
    $this->user = $user ;
    }
    public function broadcastOn(){
    //  return ['technician-reminder-channel'];
    return new PrivateChannel('technician-reminder-channel.' . $this->user->id);
    }
    // public function broadcastAs(){
    //  return 'tech-reminders';
    // }
}
