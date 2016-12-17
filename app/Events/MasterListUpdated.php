<?php

namespace App\Events;

use app\MasterList;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MasterListUpdated
{
    use InteractsWithSockets, SerializesModels;

    public $masterlist;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(MasterList $masterlist)
    {
        $this->masterlist = $masterlist;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
