<?php

namespace App\Events;

use App\Models\Game;
use App\Models\Chat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\PresenceChannel;

class MessageSent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $game;
    public $chat;

    public function __construct(Game $game, Chat $chat)
    {
        $this->game = $game;
        $this->chat = $chat;
    }

    public function broadcastOn()
    {
        return new PresenceChannel('game.' . $this->game->id);
    }
}
