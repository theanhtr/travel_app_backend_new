<?php

namespace App\Http\Controllers;

use App\Helper\GetHotelsByAddress;
use App\Helper\GetSortByIdHelper;
use App\Helper\SortObjectHelper;
use App\Helper\SplitIdInString;
use App\Http\Controllers\SearchController;
use App\Http\Requests\FilterHotelsRequest;
use App\Models\Hotel;
use App\Models\SortBy;
use App\Traits\HttpResponse;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Ramsey\Collection\Sort;

class FilterController extends Controller
{
    use HttpResponse;

    //hotel
    public function getHotelSortBy() {
        return $this->success('Get ok', SortBy::where('type', 1)->get());
    }

    public function checkAmenities(Hotel $hotel, $amenities) {
        $hotelAmenities = $hotel -> amenities() -> get();

        foreach($amenities as $amenity_id) {
            if(!$hotelAmenities -> where('id', $amenity_id) -> first()) {
                return false;
            }
        }

        return true;
    }

    public function hotelSortBy($hotels, $sort_by_id) {
        $hotelsResult = $hotels;
        if($sort_by_id == GetSortByIdHelper::getHighestPriceHotelRoleId()) {
            $hotelsResult = SortObjectHelper::sortObjectHelper($hotels, "max_price", true);
        } else if($sort_by_id == GetSortByIdHelper::getLowestPriceHotelRoleId()) {
            $hotelsResult = SortObjectHelper::sortObjectHelper($hotels, "max_price");
        } else if($sort_by_id == GetSortByIdHelper::getHighestRatingHotelRoleId()) {
            $hotelsResult = SortObjectHelper::sortObjectHelper($hotels, "rating_average", true);
        } else if($sort_by_id == GetSortByIdHelper::getNearestDistanceHotelRoleId()) {
            $hotelsResult = $hotels;
        }

        return $hotelsResult;
    }

    public function filterHotels(FilterHotelsRequest $request) {
        $hotels = Hotel::all();
        
        $hotelsByAddress = GetHotelsByAddress::getHotelsByAddress($hotels, $request -> province_id, $request -> district_id, $request -> sub_district_id);

        $hotelsByFilter = array();

        foreach($hotelsByAddress as $hotel) {
            /**
             * @var Hotel $hotel
             */
            $amenities = SplitIdInString::splitIdInString((string)$request->amenities);
            
            if($hotel->min_price >= $request -> budget_from
               && $hotel -> max_price <= $request -> budget_to
               && $hotel -> rating_average >= $request -> hotel_class
               && $this->checkAmenities($hotel, $amenities)
            ) {
                array_push($hotelsByFilter, $hotel);
            }
        }

        if (!SortBy::where([['id', $request->sort_by_id], ['type', 1]])->first()) {
            return $this->failure('Sort by type wrong');
        }

        $hotelsByFilter = $this->hotelSortBy($hotelsByFilter, $request->sort_by_id);

        return $this->success("Filter hotels success", $hotelsByFilter);
    }

    //review
    public function getReviewSortBy() {
        return $this->success('Get ok', SortBy::where('type', 3)->get());
    }

    public function filterReviews(FilterHotelsRequest $request) {
        $hotels = Hotel::all();
        
        $hotelsByAddress = GetHotelsByAddress::getHotelsByAddress($hotels, $request -> province_id, $request -> district_id, $request -> sub_district_id);

        $hotelsByFilter = array();

        foreach($hotelsByAddress as $hotel) {
            /**
             * @var Hotel $hotel
             */
            $amenities = SplitIdInString::splitIdInString((string)$request->amenities);
            
            if($hotel->min_price >= $request -> budget_from
               && $hotel -> max_price <= $request -> budget_to
               && $hotel -> rating_average >= $request -> hotel_class
               && $this->checkAmenities($hotel, $amenities)
            ) {
                array_push($hotelsByFilter, $hotel);
            }
        }

        if (!SortBy::where([['id', $request->sort_by_id], ['type', 1]])->first()) {
            return $this->failure('Sort by type wrong');
        }

        $hotelsByFilter = $this->hotelSortBy($hotelsByFilter, $request->sort_by_id);

        return $this->success("Filter hotels success", $hotelsByFilter);
    }
}