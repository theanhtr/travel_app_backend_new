<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomReservationTime extends Model
{
    use HasFactory;

    public $fillable = ['check_in_date', 'check_out_date'];
}
