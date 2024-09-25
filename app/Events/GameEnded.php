<?php

namespace App\Events;

use App\Models\Game;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\PresenceChannel;

class GameEnded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $game;
    public $reason;

    public function __construct(Game $game, $reason)
    {
        $this->game = $game;
        $this->reason = $reason;
    }

    public function broadcastOn()
    {
        return new PresenceChannel('game.' . $this->game->id);
    }
}
