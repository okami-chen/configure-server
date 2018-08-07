<?php

namespace OkamiChen\ConfigureServer\Event;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ConfigChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $id;
    
    protected $change;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($id, $change)
    {
        $this->id       = $id;
        $this->change   = $change;
    }
    
    public function toArray(){
        return [
            'id'        => $this->id,
            'change'    => $this->change
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
