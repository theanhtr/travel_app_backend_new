<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelAmenity extends Model
{
    protected $fillable = [
        'hotel_id',
        'amenity_id',
    ];
}
