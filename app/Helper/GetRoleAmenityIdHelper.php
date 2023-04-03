<?php 

namespace App\Helper;

use App\Models\RoleAmenity;

class GetRoleAmenityIdHelper {
    public static function getHotelRoleAmenityId():int
    {
        return RoleAmenity::where('name', '=', 'Hotel')->first()->id;
    }

    public static function getRoomRoleAmenityId():int
    {
        return RoleAmenity::where('name', '=', 'Room')->first()->id;
    }

    public static function getAirlineRoleAmenityId():int
    {
        return RoleAmenity::where('name', '=', 'Airline')->first()->id;
    }

    public static function getFlightRoleAmenityId():int
    {
        return RoleAmenity::where('name', '=', 'Flight')->first()->id;
    }
}