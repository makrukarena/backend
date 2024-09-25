<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Game;
use App\Events\MessageSent;
use Auth;

class ChatController extends Controller
{
    public function send(Request $request, Game $game)
    {
        $chat = Chat::create([
            'game_id' => $game->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        // Trigger MessageSent event
        broadcast(new MessageSent($game, $chat))->toOthers();

        return response()->json(['chat' => $chat], 201);
    }
}
