<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = [
        'body',
        'read',
        'conversation_id',
        'sender_id',
        'receiver_id'
    ];

    public function conversation():BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
