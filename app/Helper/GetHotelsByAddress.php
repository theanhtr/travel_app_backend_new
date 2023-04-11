<?php 

namespace App\Helper;

use App\Models\Address;
use App\Models\Hotel;
use App\Models\User;
use App\Models\Role;
use App\Traits\HttpResponse;
use Illuminate\Database\Eloquent\Collection;

class GetHotelsByAddress {
    use HttpResponse;
    public static function getHotelsByAddress(Collection $hotels, $province_id, $district_id, $sub_district_id)
    {
        $hotelsFilter = array();
        
        //find hotels near me
        if($province_id == null) {
            return $hotelsFilter;
        }

        foreach($hotels as $hotel) {
            $address = $hotel->address()->first();
            /**
             * @var Address $address
             */

            if($sub_district_id) {
                if ($address -> sub_district_id == $sub_district_id) {
                    array_push($hotelsFilter, $hotel);
                }
                continue;
            }

            if($district_id) {
                if($address -> district_id == $district_id) {
                    array_push($hotelsFilter, $hotel);
                }
                continue;
            }

            if($province_id && $address -> province_id == $province_id) {
                array_push($hotelsFilter, $hotel);
            }
        }

        return $hotelsFilter;
    }
}