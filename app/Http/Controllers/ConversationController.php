<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    use HttpResponse;
    public function create() {
        $user = Auth::user();
        /**
         * @var User $user
         */

        $this->authorize('create', Conversation::class);

        $exists = Conversation::where([
                ['is_closed', false],
                ['sender_id', $user->id]
            ]) -> orWhere([
                ['is_closed', false],
                ['receiver_id', $user->id]
            ]) -> first();

        if($exists) {
            return $this->failure('Conversation is exists');
        }

        $coversation = $user -> conversations() -> create([
            'last_time_message' => now(),
            'receiver_id' => 22
        ]);

        return $this -> success('Create conversation compleate', $coversation);
    }
}
