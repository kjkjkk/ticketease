<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotifyTechnicianAssignTicket implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // ----------------wala paniiiiiii----------------
    public $result ;
    public function __construct($result ){
     $this -> result  = $result ;
    }
    public function broadcastOn(){
     return ['notify-channel'];
    }
    public function broadcastAs(){
     return 'form-submitted';
    }
}
