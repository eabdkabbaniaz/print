<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrder implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $section = [];

    public function __construct($message, $section)
    {
        $this->message = $message;
        $this->section = $section;
    }

    public function broadcastOn()
    {
        return  ['my-channel'];
    }

    public function broadcastAs()
    {
        return 'my-event';
    }
}
