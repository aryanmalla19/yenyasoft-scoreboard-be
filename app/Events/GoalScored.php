<?php

namespace App\Events;

use App\Models\Event;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GoalScored implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Event $event)
    {
        $this->event->loadMissing('match');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): Channel
    {
        return new Channel('scoreboard');
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->event->id,
            'type' => $this->event->type,
            'team_id' => $this->event->team_id,
            'player_id' => $this->event->player_id,
            'event_by' => $this->event->team_id === $this->event->match->home_team_id ? 'home' : 'away',
            'match_score' => [
                'home' => $this->event->match->home_score,
                'away' => $this->event->match->away_score,
            ],
        ];
    }
}
