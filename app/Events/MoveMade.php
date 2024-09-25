<?php

namespace App\Events;

use App\Models\Game;
use App\Models\Move;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\PresenceChannel;

class MoveMade
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $game;
    public $move;

    public function __construct(Game $game, Move $move)
    {
        $this->game = $game;
        $this->move = $move;
    }

    public function broadcastOn()
    {
        return new PresenceChannel('game.' . $this->game->id);
    }
}
