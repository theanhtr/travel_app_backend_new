<?php 

namespace App\Helper;

use App\Models\RoleImage;

class GetRoleImageIdHelper {
    public static function getAvatarRoleImageId():int
    {
        return RoleImage::where('name', '=', 'Avatar')->first()->id;
    }

    public static function getTouristAttractionRoleImageId():int
    {
        return RoleImage::where('name', '=', 'Tourist Attraction')->first()->id;
    }

    public static function getHotelRoleImageId():int
    {
        return RoleImage::where('name', '=', 'Hotel')->first()->id;
    }

    public static function getHotelRoomRoleImageId():int
    {
        return RoleImage::where('name', '=', 'Hotel Room')->first()->id;
    }

    public static function getRatingRoleImageId():int
    {
        return RoleImage::where('name', '=', 'Rating')->first()->id;
    }

    public static function getAirlineRoleImageId():int
    {
        return RoleImage::where('name', '=', 'Airline')->first()->id;
    }

    public static function getAirlineAircraftRoleImageId():int
    {
        return RoleImage::where('name', '=', 'Airline Aircraft')->first()->id;
    }

    public static function getAirlineFlightRoleImageId():int
    {
        return RoleImage::where('name', '=', 'Airline Flight')->first()->id;
    }
}