<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'last_time_message',
        'sender_id',
        'receiver_id',
        'is_closed',
        'rating_star'
    ];

    public function messages():HasMany 
    {
        return $this->hasMany(Message::class);
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
