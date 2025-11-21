<?php

namespace App\Events;

use App\Models\Event;
use App\Models\MatchModal;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MatchStarted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public MatchModal $match, public Event $event)
    {}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): Channel
    {
        return new Channel('scoreboard');
    }

    public function broadcastWith(): array
    {
        return [
            'match' => $this->match,
            'event' => $this->event,
        ];
    }
}
