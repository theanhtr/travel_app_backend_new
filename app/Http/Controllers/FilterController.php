<?php

namespace App\Http\Controllers;

use App\Helper\GetHotelReviews;
use App\Helper\GetHotelsByAddress;
use App\Helper\GetSortByIdHelper;
use App\Helper\ImageGetHelper;
use App\Helper\SortObjectHelper;
use App\Helper\SplitIdInString;
use App\Http\Controllers\SearchController;
use App\Http\Requests\FilterHotelsRequest;
use App\Http\Requests\FilterReviewsRequest;
use App\Models\Address;
use App\Models\District;
use App\Models\Hotel;
use App\Models\Province;
use App\Models\Review;
use App\Models\SortBy;
use App\Models\SubDistrict;
use App\Models\TypeFilterReview;
use App\Traits\HttpResponse;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Ramsey\Collection\Sort;

class FilterController extends Controller
{
    use HttpResponse;

    //hotel
    public function hotelFilterOption() {
        return $this->success('Get ok', ['sort_by' => SortBy::where('type', 1)->get()]);
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
            $hotelsResult = $hotels->sortByDesc("max_price");
        } else if($sort_by_id == GetSortByIdHelper::getLowestPriceHotelRoleId()) {
            $hotelsResult = $hotels->sortBy("max_price");
        } else if($sort_by_id == GetSortByIdHelper::getHighestRatingHotelRoleId()) {
            $hotelsResult = $hotels->sortByDesc("rating_average");
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
               && $hotel -> rating_average >= $request -> rating_average
               && $this->checkAmenities($hotel, $amenities)
            ) {
                array_push($hotelsByFilter, $hotel);
            }
        }

        if (!SortBy::where([['id', $request->sort_by_id], ['type', 1]])->first()) {
            return $this->failure('Sort by type wrong');
        }

        $hotelsByFilter = collect($hotelsByFilter);
        $hotelsByFilter = $this->hotelSortBy($hotelsByFilter, $request->sort_by_id);

        foreach($hotelsByFilter as $hotel) {
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

        $hotels_response = [];

        foreach ($hotelsByFilter as $value) {
            array_push($hotels_response,$value);
        }

        return $this->success("Filter hotels success", $hotels_response);
    }

    //review
    public function reviewFilterOption() {
        $sort_by = SortBy::where('type', 3)->get();
        $type = TypeFilterReview::get();
        return $this->success('Get ok', ['sort_by' => $sort_by, 'type_review' => $type]);
    }

    public function reviewsWithType($reviews, $type_id) {
        $reviewsResult = array();

        if($type_id == 1) { //all
            return $reviews;
        }

        foreach($reviews as $review) {
            /**
             * @var Review $review
             */
            if($type_id == 2) { //with comment
                if($review -> comment) {
                    array_push($reviewsResult, $review);
                }
            } else if($type_id == 3) { //with photos
                if($review -> images() -> exists()) {
                    array_push($reviewsResult, $review);
                }
            }
        }
        
        return $reviewsResult;
    }

    public function reviewsSortBy($reviews, $sort_by_id) {
        $reviewsResult = $reviews;
        if($sort_by_id == GetSortByIdHelper::getHightoLowScoreReviewRoleId()) {
            $reviewsResult = $reviews->sortByDesc('star_rating');
        } else if($sort_by_id == GetSortByIdHelper::getLowtoHighScoreReviewRoleId()) {
            $reviewsResult = $reviews->sortBy('star_rating');
        } 
        
        return $reviewsResult;
    }

    public function filterReviews(FilterReviewsRequest $request) {
        $hotel = Hotel::find($request -> hotel_id);

        if(!$hotel) {
            return $this->failure('Hotel is not exist');
        }

        $hotel_reviews = GetHotelReviews::getHotelReviews($hotel);
        
        $hotel_reviews_filter = array();

        //rating
        foreach($hotel_reviews as $review) {
            /**
             * @var Review $review
             */

            if($request -> star_rating) {
                if($review -> star_rating == (int)$request -> star_rating) {
                    array_push($hotel_reviews_filter, $review);
                }
            } else {
                array_push($hotel_reviews_filter, $review);
            }
        }

        //type: all, comment, image
        if (!TypeFilterReview::find($request -> type_id)) {
            return $this->failure('Type wrong');
        }

        $hotel_reviews_filter = $this -> reviewsWithType($hotel_reviews_filter, $request->type_id);

        if (!SortBy::where([['id', $request->sort_by_id], ['type', 3]])->first()) {
            return $this->failure('Sort by type wrong');
        }

        //sort
        $hotel_reviews_filter = collect($hotel_reviews_filter);
        $hotel_reviews_filter = $this->reviewsSortBy($hotel_reviews_filter, $request->sort_by_id);
        
        $hotels_response = [];

        foreach ($hotel_reviews_filter as $value) {
            array_push($hotels_response,$value);
        }

        $reviews_response['reviews'] = $hotels_response;
        
        $reviews_response['count_rating'] = $hotel -> reviews() -> count();
        $reviews_response['five_star_rating'] = $hotel -> reviews() -> where('star_rating', '=', 5) -> count();
        $reviews_response['four_star_rating'] = $hotel -> reviews() -> where('star_rating', '=', 4) -> count();
        $reviews_response['three_star_rating'] = $hotel -> reviews() -> where('star_rating', '=', 3) -> count();
        $reviews_response['two_star_rating'] = $hotel -> reviews() -> where('star_rating', '=', 2) -> count();
        $reviews_response['one_star_rating'] = $hotel -> reviews() -> where('star_rating', '=', 1) -> count();
        $reviews_response['rating_average'] = $hotel -> rating_average;
        
        return $this->success("Filter reviews success", $reviews_response);
    }
}