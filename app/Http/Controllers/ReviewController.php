<?php

namespace App\Http\Controllers;

use App\Helper\GetHotelReviews;
use App\Helper\GetOrderStatusIdHelper;
use App\Helper\GetRoleImageIdHelper;
use App\Helper\ImageGetHelper;
use App\Helper\ImageUploadHelper;
use App\Models\Hotel;
use App\Models\Image;
use App\Models\Order;
use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\SortBy;
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ReviewController extends Controller
{
    use HttpResponse;
    public function createReview(StoreReviewRequest $request) {
        $user = Auth::user();
        /**
        * @var User $user
        */

        $order = $user -> orders() -> find($request -> order_id);
        /**
         * @var Order $order
         */

        if(!$order) {
            return $this->failure('Order is not exist');
        }

        if(!($order -> order_status_id === GetOrderStatusIdHelper::getAwaitingFeedbackOrderStatusId())) {
            return $this->failure('Order status is not true, must be await feedback');
        }

        $review = Review::create([
            'comment' => $request -> comment ?? null,
            'star_rating' => $request -> star_rating,
            'can_update' => true,
            'user_private' => $request -> user_private ?? false,
            'count_like' => 0,
            'count_dislike' => 0,
            'is_block' => false,
            'order_id' => $request -> order_id,
            'user_id' => $order -> user_id,
            'hotel_id' => $order -> hotel_id,
            'type_room_id' => $order -> type_room_id,
        ]);
        
        $order -> order_status_id = GetOrderStatusIdHelper::getCompletedOrderStatusId();
        $order -> save();
        
        ImageUploadHelper::uploadMutipleImage($request, GetRoleImageIdHelper::getRatingRoleImageId(), null, null, $review -> id);

        $images_review = ImageGetHelper::imageGetHelper($review);

        $review['images'] = $images_review;

        $hotel = $review -> hotel() -> first();
        /**
         * @var Hotel $hotel
         */

        $count_review = $hotel -> reviews() -> count();
        $sum_star_review = $hotel -> reviews() -> sum('star_rating');
        $rating_average = round($sum_star_review / $count_review, 1);

        $hotel -> rating_average = $rating_average;
        $hotel -> save();

        return $this->success('Create review complete', $review);
    }

    public function allHotelReview($hotel_id) {
        $hotel = Hotel::find($hotel_id);

        if(!$hotel) {
            return $this->failure('Hotel is not exist');
        }

        $hotel_reviews = GetHotelReviews::getHotelReviews($hotel);
        
        $reviews_response['reviews'] = $hotel_reviews;

        $reviews_response['count_rating'] = $hotel -> reviews() -> count();
        $reviews_response['five_star_rating'] = $hotel -> reviews() -> where('star_rating', '=', 5) -> count();
        $reviews_response['four_star_rating'] = $hotel -> reviews() -> where('star_rating', '=', 4) -> count();
        $reviews_response['three_star_rating'] = $hotel -> reviews() -> where('star_rating', '=', 3) -> count();
        $reviews_response['two_star_rating'] = $hotel -> reviews() -> where('star_rating', '=', 2) -> count();
        $reviews_response['one_star_rating'] = $hotel -> reviews() -> where('star_rating', '=', 1) -> count();
        $reviews_response['rating_average'] = $hotel -> rating_average;
        
        return $this->success('Get ok', $reviews_response);
    }
}
