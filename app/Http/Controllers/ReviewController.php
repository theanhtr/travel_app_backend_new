<?php

namespace App\Http\Controllers;

use App\Helper\GetHotelReviews;
use App\Helper\GetOrderStatusIdHelper;
use App\Helper\GetRoleImageIdHelper;
use App\Helper\ImageGetHelper;
use App\Helper\ImageUploadHelper;
use App\Helper\SplitIdInString;
use App\Models\Hotel;
use App\Models\Image;
use App\Models\Order;
use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\LikeReviewsRequest;
use App\Http\Requests\ReportReviewsRequest;
use App\Http\Requests\LikeReviewsRequestTest;
use App\Http\Requests\ReportReviewRequest;
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

    public function likeReviewsTest(LikeReviewsRequestTest $request) {
        $user = Auth::user();
        /**
         * @var User $user
         */

        $like_ids = SplitIdInString::splitIdInString($request -> like);
        $dislike_ids = SplitIdInString::splitIdInString($request -> dislike);
        $unlike_ids = SplitIdInString::splitIdInString($request -> unlike);

        foreach($like_ids as $id) {
            if ($user->likeReviews()->wherePivot('review_id', $id)->exists()) {
                $user->likeReviews()->updateExistingPivot($id, ['is_like' => true]);
            } else {
                $user->likeReviews()->attach($id, ['is_like' => true]);
            }
        }

        foreach($dislike_ids as $id) {
            if ($user->likeReviews()->wherePivot('review_id', $id)->exists()) {
                $user->likeReviews()->updateExistingPivot($id, ['is_like' => false]);
            } else {
                $user->likeReviews()->attach($id, ['is_like' => false]);
            }
        }

        foreach($unlike_ids as $id) {
            $user->likeReviews()->detach($id);
        }

        return $this -> success('Update like ok');
    }

    public function reportReviewsTest(ReportReviewsRequest $request) {
        $user = Auth::user();
        /**
         * @var User $user
         */

        $report_ids = SplitIdInString::splitIdInString($request -> report);

        $user->reportReviews()->syncWithoutDetaching($report_ids);
        
        foreach($report_ids as $id) {
            $review = Review::find($id);
            /**
             * @var Review $review
             */

            if($review -> reportReviews() -> count() >= 5) {
                $review -> is_block = 1;
                $review -> save();
            }
        }

        return $this -> success('Report ok');
    }

    public function likeReviews(LikeReviewsRequest $request) {
        $user = Auth::user();
        /**
         * @var User $user
         */

         //1 - like; 2 - dislike; 3 - unlike,undislike
        //  'status' => 'required|numeric|in:1,2,3'

        $review_id = $request -> review_id;
        
        $review = Review::find($review_id);
        /**
         * @var Review $review
         */

         if(!$review) {
            return $this->failure('Review not found');
        }

        if($request -> status == 1) {
            if ($user->likeReviews()->wherePivot('review_id', $review_id)->exists()) {
                $user->likeReviews()->updateExistingPivot($review_id, ['is_like' => true]);
            } else {
                $user->likeReviews()->attach($review_id, ['is_like' => true]);
            }
        } else if($request -> status == 2) {
            if ($user->likeReviews()->wherePivot('review_id', $review_id)->exists()) {
                $user->likeReviews()->updateExistingPivot($review_id, ['is_like' => false]);
            } else {
                $user->likeReviews()->attach($review_id, ['is_like' => false]);
            }
        } else if($request -> status == 3) {
            $user->likeReviews()->detach($review_id);
        }

        return $this -> success('Update like ok');
    }

    public function reportReviews(ReportReviewRequest $request) {
        $user = Auth::user();
        /**
         * @var User $user
         */

        $review_id = $request -> review_id;
        
        $review = Review::find($review_id);
        /**
         * @var Review $review
         */

        if(!$review) {
            return $this->failure('Review not found');
        }

        $user->reportReviews()->syncWithoutDetaching($review_id);
        

        if($review -> reportReviews() -> count() >= 5) {
            $review -> is_block = 1;
            $review -> save();
        }
        
        return $this -> success('Report ok');
    }
}
