<?php

namespace App\Http\Controllers;

use App\Helper\GetOrderStatusIdHelper;
use App\Helper\GetRoleImageIdHelper;
use App\Helper\ImageUploadHelper;
use App\Models\Hotel;
use App\Models\Order;
use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
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
            return $this->failure('Order status is not true');
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

        $images_review = $review -> images()->get();

        $imagesResponse = array();

        foreach($images_review as $image) {
            $image_temp = array();
            $image_temp["id"] = $image->id;
            $image_temp["path"] = asset('uploads/' . $image->path);
            array_push($imagesResponse, $image_temp);
        }

        $review['images'] = $imagesResponse;

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

        $hotel_reviews = $hotel -> reviews() -> get();

        foreach($hotel_reviews as $hotel_review) {
            $hotel_review['type_room_name'] = $hotel_review -> typeRoom() -> first() -> name;

            $user = $hotel_review -> user() -> first();
            /**
             * @var User $user
             */
            $user_infor = $user -> information() -> first();
            
            if($hotel_review -> user_private) {
                $hotel_review['user_name'] = $user_infor -> first_name . ' ' . $user_infor -> last_name;
            } else {
                $hotel_review['user_name'] = $user_infor -> first_name[0] . '**' . $user_infor -> last_name[0] . '**';
            }
        }

        return $this->success('Get ok', $hotel_reviews);
    }

    public function updateReview() {
        
    }
}
