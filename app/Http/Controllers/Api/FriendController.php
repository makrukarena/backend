<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Friend;
use Auth;

class FriendController extends Controller
{
    public function addFriend(Request $request)
    {
        $friend = Friend::create([
            'user_id' => Auth::id(),
            'friend_user_id' => $request->friend_user_id,
        ]);

        return response()->json(['friend' => $friend], 201);
    }

    public function removeFriend($friend_id)
    {
        $friend = Friend::where('user_id', Auth::id())
            ->where('friend_user_id', $friend_id)
            ->first();

        if ($friend) {
            $friend->delete();
            return response()->json(['message' => 'Friend removed'], 200);
        }

        return response()->json(['message' => 'Friend not found'], 404);
    }
}
