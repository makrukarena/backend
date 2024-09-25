<?php

use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\FriendController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/register', [UserController::class, 'store']);
Route::get('/login', [UserController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/game/start', [GameController::class, 'start']);
    Route::post('/game/move', [GameController::class, 'move']);
    Route::post('/game/resign', [GameController::class, 'resign']);
    Route::post('/chat/send', [ChatController::class, 'send']);
    Route::post('/friends/add', [FriendController::class, 'addFriend']);
});
