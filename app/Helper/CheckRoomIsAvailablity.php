<?php 

namespace App\Helper;

use App\Models\Room;
use DateTime;

class CheckRoomIsAvailablity {
    public static function checkRoomIsAvailablity(Room $room, DateTime $check_in_date, DateTime $check_out_date)
    {
        $room_reservation_times = $room -> roomReservationTimes() -> get();

        if(!$room_reservation_times) {
            return true;
        } else {
            $availablity = true;
            foreach($room_reservation_times as $room_reservation_time) {
                $room_check_in_date = new DateTime($room_reservation_time -> check_in_date);
                $room_check_out_date = new DateTime($room_reservation_time -> check_out_date);

                if($room_check_in_date -> getTimestamp() <= $check_in_date -> getTimestamp() && $room_check_out_date -> getTimestamp() >= $check_in_date -> getTimestamp()
                || $room_check_in_date -> getTimestamp() <= $check_out_date -> getTimestamp() && $room_check_out_date -> getTimestamp() >= $check_out_date -> getTimestamp()) {
                    $availablity = false;
                    break;
                }
            }
            
            return $availablity;
        }   
    }
}