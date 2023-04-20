<?php 

namespace App\Helper;

use App\Models\Role;

class GetRoleIdHelper {
    public static function getAdminRoleId():int
    {
        return Role::where('name', '=', 'Admin')->first()->id;
    }

    public static function getCustomerRoleId():int
    {
        return Role::where('name', '=', 'Customer')->first()->id;
    }

    public static function getHotelManagerRoleId():int
    {
        return Role::where('name', '=', 'Hotel Manager')->first()->id;
    }

    public static function getAirlineManagerRoleId():int
    {
        return Role::where('name', '=', 'Airline Manager')->first()->id;
    }

    public static function getTravelStaffRoleId():int
    {
        return Role::where('name', '=', 'Travel Staff')->first()->id;
    }
}