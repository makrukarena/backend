<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Move;
use App\Events\GameStarted;
use App\Events\MoveMade;
use App\Events\GameEnded;
use Auth;

class GameController extends Controller
{
    public function start(Request $request)
    {
        $game = Game::create([
            'player_1_id' => Auth::id(),
            'player_2_id' => $request->player_2_id,
            'start_time' => now(),
            'time_per_move' => $request->time_per_move,
        ]);

        // Trigger GameStarted event
        broadcast(new GameStarted($game))->toOthers();

        return response()->json(['game' => $game], 201);
    }

    public function move(Request $request, Game $game)
    {
        $move = Move::create([
            'game_id' => $game->id,
            'move_number' => $game->moves()->count() + 1,
            'move_notation' => $request->move_notation,
        ]);

        // Trigger MoveMade event
        broadcast(new MoveMade($game, $move))->toOthers();

        return response()->json(['move' => $move], 200);
    }

    public function resign(Game $game)
    {
        $game->update(['game_resigned' => true, 'end_time' => now()]);

        // Trigger GameEnded event
        broadcast(new GameEnded($game, 'resigned'))->toOthers();

        return response()->json(['game' => $game], 200);
    }

    public function draw(Game $game)
    {
        $game->update(['game_draw' => true, 'end_time' => now()]);

        // Trigger GameEnded event
        broadcast(new GameEnded($game, 'draw'))->toOthers();

        return response()->json(['game' => $game], 200);
    }
}
