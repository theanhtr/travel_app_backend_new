<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Room extends Model
{
    protected $fillable = 
    [
        'availablity', 
        'type_room_id'
    ];

    public function typeRoom():BelongsTo
    {
        return $this->belongsTo(TypeRoom::class);
    }

    public function roomReservationTimes():HasMany
    {
        return $this->hasMany(RoomReservationTime::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'room_order', 'room_id', 'order_id');
    }
}
