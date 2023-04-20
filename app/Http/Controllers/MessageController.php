<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    use HttpResponse;
    public function sendMessage(StoreMessageRequest $request) {
        $user = Auth::user();
        /**
         * @var User $user
         */

        $conversation = Conversation::where([
                ['is_closed', false],
                ['sender_id', $user->id]
            ]) -> orWhere([
                ['is_closed', false],
                ['receiver_id', $user->id]
            ]) -> first();

        if(!$conversation) {
            return $this->failure('Conversation not found');
        }

        $message = $conversation -> messages() -> create([
            'body' => $request -> body,
            'sender_id' => $user -> id,
            'receiver_id' => $conversation -> receiver_id
        ]);

        $conversation -> last_time_message = now();

        return $this->success("Send message done", $message);
    }

    public function getMessages() {
        $user = Auth::user();
        /**
         * @var User $user
         */

        $conversation = Conversation::where([
                ['is_closed', false],
                ['sender_id', $user->id]
            ]) -> orWhere([
                ['is_closed', false],
                ['receiver_id', $user->id]
            ]) -> first();

        if(!$conversation) {
            return $this->failure('Conversation not found');
        }

        $messages = $conversation -> messages() -> get();

        foreach($messages as $message) {
            if($message -> sender_id == $user -> id) {
                $message['type'] = 'sender';
            } else if ($message -> receiver_id == $user -> id) {
                $message['type'] = 'receiver';
            }
        }

        return $this->success("Get message done", $messages);
    }
}
