<?php

namespace App\Http\Controllers;

use App\Helper\ImageGetHelper;
use App\Models\Address;
use App\Models\District;
use App\Models\Hotel;
use App\Models\PopularDestination;
use App\Models\Province;
use App\Models\SubDistrict;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLikeController extends Controller
{
    use HttpResponse;
    public function likeHotel($hotel_id) {
        $hotel = Hotel::find($hotel_id);

        if(!$hotel) {
            return $this->failure('Hotel not found');
        }

        $user = Auth::user();
        /**
         * @var User $user
         */

        $like = $user->hotelsLike()->toggle($hotel_id);
        return $this->success('Ok', ['is_like' => ($like['attached'] ? true : false)]);
    }

    public function likePopularDestination($popular_destination_id) {
        $popular_destination = PopularDestination::find($popular_destination_id);

        if(!$popular_destination) {
            return $this->failure('Popular destination not found');
        }

        $user = Auth::user();
        /**
         * @var User $user
         */

        $like = $user->popularDestinationsLike()->toggle($popular_destination_id);
        return $this->success('Ok', ['is_like' => ($like['attached'] ? true : false)]);
    }

    public function getHotelsLike() {
        $user = Auth::user();
        /**
         * @var User $user
         */

        $hotels = $user -> hotelsLike() -> get();
        
        foreach($hotels as $hotel) {
            $hotel['images'] = ImageGetHelper::imageGetHelper($hotel);
            $hotel['count_review'] = $hotel -> reviews() -> count();

            $address = Address::find($hotel -> address_id);

            if($address) {
                $addressResponse = array();
                $addressResponse['specific_address'] = $address -> specific_address;
                $addressResponse['province'] = Province::find($address->province_id)->name;
                $addressResponse['district'] = District::find($address->district_id)->name;
                $addressResponse['sub_district'] = SubDistrict::find($address->sub_district_id)->name;
            }

            $hotel['address'] = $addressResponse;
        }

        return $this->success("Search hotels complete", $hotels);
    }
}
