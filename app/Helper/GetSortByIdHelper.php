<?php 

namespace App\Helper;

use App\Models\SortBy;

class GetSortByIdHelper {
    public static function getLowestPriceHotelRoleId():int
    {
        return SortBy::where([['name', '=', 'Lowest Price'], ['type', '=', 1]])->first()->id;
    }

    public static function getHighestPriceHotelRoleId(): int
    {
        return SortBy::where([['name', '=', 'Highest Price'], ['type', '=', 1]])->first()->id;
    }

    public static function getHighestRatingHotelRoleId(): int
    {
        return SortBy::where([['name', '=', 'Highest Rating'], ['type', '=', 1]])->first()->id;
    }


    public static function getNearestDistanceHotelRoleId(): int
    {
        return SortBy::where([['name', '=', 'Nearest Distance'], ['type', '=', 1]])->first()->id;
    }

    //flight
    public static function getEarliestDepartureFlightRoleId(): int
    {
        return SortBy::where([['name', '=', 'Earliest Departure'], ['type', '=', 2]])->first()->id;
    }

    public static function getLatestDepartureFlightRoleId(): int
    {
        return SortBy::where([['name', '=', 'Latest Departure'], ['type', '=', 2]])->first()->id;
    }
    
    public static function getEarliestArriveFlightRoleId(): int
    {
        return SortBy::where([['name', '=', 'Earliest Arrive'], ['type', '=', 2]])->first()->id;
    }

    public static function getLatestArriveFlightRoleId(): int
    {
        return SortBy::where([['name', '=', 'Latest Arrive'], ['type', '=', 2]])->first()->id;
    }

    public static function getShortestDurationFlightRoleId(): int
    {
        return SortBy::where([['name', '=', 'Shortest Duration'], ['type', '=', 2]])->first()->id;
    }

    public static function getHighestPriceFlightRoleId(): int
    {
        return SortBy::where([['name', '=', 'Highest Price'], ['type', '=', 2]])->first()->id;
    }

    public static function getLowestPriceFlightRoleId(): int
    {
        return SortBy::where([['name', '=', 'Lowest Price'], ['type', '=', 2]])->first()->id;
    }
}