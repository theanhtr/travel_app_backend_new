<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = 
    [
        'customer_name',
        'email_contact',
        'phone_number_contact',
        'customer_note',
        'total_price',
        'time_order',
        'room_quantity',
        'check_in_date',
        'check_out_date',
        'order_status_id',
        'user_id',
        'type_room_id',
        'hotel_id', 
        'amount_of_people'
    ];

    protected $hidden = [
        'payment_id'
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function typeRoom():BelongsTo
    {
        return $this->belongsTo(TypeRoom::class);
    }

    public function hotel():BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function orderStatus():BelongsTo
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function rooms():BelongsToMany
    {
        return $this->belongsToMany(Room::class, 'room_order', 'order_id', 'room_id');
    }

    public function roomReservationTimes():HasMany
    {
        return $this->hasMany(RoomReservationTime::class);
    }

    public function review():HasOne
    {
        return $this->hasOne(Review::class);
    }
}

