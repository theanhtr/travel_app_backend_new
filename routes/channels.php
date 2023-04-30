<?php

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('conversation.{conversationId}', function (User $user,int $conversationId) {
    $conversation = Conversation::find($conversationId);

    return (int) $user->id === (int) $conversation -> sender_id
            || (int) $user->id === (int) $conversation -> receiver_id;
});