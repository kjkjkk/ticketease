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

class WelcomeUser implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user ;
    // public $User ;
    // public $result ;
    public function __construct( User $user ){
    $this -> user  = $user ;
    //  $this -> result  = $result ;
    }
    public function broadcastOn(){
    //  return ['login-channel'];
    return new PrivateChannel('login-channel.' . $this->user->id);
    }
    // public function broadcastAs(){
    //  return 'form-submitted';
    // }
}
