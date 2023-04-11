<?php 

namespace App\Helper;

use App\Models\Hotel;
use App\Models\User;
use App\Models\Role;
use App\Traits\HttpResponse;

class ChangeHotelMinMaxPrice {
    use HttpResponse;
    public static function changeHotelMinMaxPrice(User $user)
    {
        $myHotel = $user->hotel()->first();

        /**
         * @var Hotel $myHotel
         */

        $typeRooms = $myHotel -> typeRooms() -> get();

        foreach($typeRooms as $typeRoom) {
            if($myHotel -> min_price > $typeRoom->price || $myHotel -> min_price == null) {
                $myHotel -> min_price = $typeRoom->price;
            }

            if($myHotel -> max_price < $typeRoom->price || $myHotel -> max_price == null) {
                $myHotel -> max_price = $typeRoom->price;
            }
        }

        $myHotel -> save();
    }
}