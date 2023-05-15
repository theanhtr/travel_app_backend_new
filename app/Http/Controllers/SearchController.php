<?php

namespace App\Http\Controllers;

use App\Helper\CheckRoomIsAvailablity;
use App\Helper\GetHotelsByAddress;
use App\Helper\ImageGetHelper;
use App\Http\Requests\SearchHotelsRequest;
use App\Http\Requests\SearchTypeRoomsRequest;
use App\Http\Requests\SearchHotelsAtPopularDestinationRequest;
use App\Http\Requests\SearchHotelsWithFulltextRequest;
use App\Models\Address;
use App\Models\District;
use App\Models\Hotel;
use App\Models\Province;
use App\Models\Room;
use App\Models\SubDistrict;
use App\Models\User;
use App\Traits\HttpResponse;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    use HttpResponse;
    public function searchHotels(SearchHotelsRequest $request) {
        $hotels = Hotel::all();
        
        $hotelsFilter = GetHotelsByAddress::getHotelsByAddress($hotels, $request -> province_id, $request -> district_id, $request -> sub_district_id);

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

        return $this->success("Search hotels complete", $hotelsFilter);
    }

    public function searchTypeRooms(SearchTypeRoomsRequest $request) {
        $hotel = Hotel::find($request->hotel_id);
        
        if(!$hotel) {
            return $this->failure("Hotel isn't exist");
        }

        $check_in_date = new DateTime($request -> check_in_date);
        $check_out_date = new DateTime($request -> check_out_date);
        $guest_quantity = $request -> guest_quantity;
        $room_quantity = $request -> room_quantity;

        if ($guest_quantity < $room_quantity) {
            return $this->failure("Room quantity can not greater than guest quantity");
        }

        $quantity_people_per_room = ceil($guest_quantity / $room_quantity);

        $typeRooms = $hotel -> typeRooms() -> get();
        $typeRoomResponse = array();

        foreach($typeRooms as $typeRoom) {
            if ($typeRoom -> occupancy < $quantity_people_per_room) {
                continue;
            }

            $rooms = $typeRoom -> rooms() -> get();
            $count_availablity_room = 0;

            foreach($rooms as $room) {
                /**
                 * @var Room $room
                 */

                 $availablity = CheckRoomIsAvailablity::checkRoomIsAvailablity($room, $check_in_date, $check_out_date);

                if($availablity) {
                    $count_availablity_room++;
                }
            }

            if($count_availablity_room < $room_quantity) {
                continue;
            }

            $typeRoom["count_availablity_room"] = $count_availablity_room;
            $typeRoom["amenities"] = $typeRoom -> amenities() -> get();

            $typeRoom["images"] = ImageGetHelper::imageGetHelper($typeRoom);

            array_push($typeRoomResponse, $typeRoom);
        }
        
        return $this->success("Search type rooms complete", $typeRoomResponse);
    }

    public function searchHotelsAtPopularDestination(SearchHotelsAtPopularDestinationRequest $request) {
        $hotels = Hotel::all();
        
        $hotelsFilter = GetHotelsByAddress::getHotelsByAddress($hotels, $request -> province_id);

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

        return $this->success("Search hotels at popular destination complete", $hotelsFilter);
    }

    public function getHotelSearch($hotel_id) {
        $hotel = Hotel::find($hotel_id);
        
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
        
        $amenities = $hotel -> amenities() -> get();
        $hotel['amenities'] = $amenities;

        $user = Auth::user();
        /**
         * @var User $user
         */

        $hotel['is_like'] = $user->hotelsLike()->wherePivot('hotel_id', $hotel_id) ->exists();

        return $this->success("Get hotel complete", $hotel);
    }

    public function searchHotelsWithFulltext(SearchHotelsWithFulltextRequest $request) {
        $hotels = Hotel::search($request -> search_name) -> get();

        return $this->success('Search ok', $hotels);
    }
}
