<?php 

namespace App\Helper;

use App\Models\Hotel;
use App\Models\Image;
use App\Models\Review;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Database\Eloquent\Collection;

class GetHotelReviews {
    use HttpResponse;
    public static function getHotelReviews(Hotel $hotel)
    {
        $hotel_reviews = $hotel -> reviews() -> get();
        $reviews_response = array();
        foreach($hotel_reviews as $hotel_review) {
            /**
             * @var Review $hotel_review
             */
            if($hotel_review -> is_block == 0) {
                $hotel_review['count_like'] = $hotel_review -> likeReviews() -> wherePivot('is_like', 1) -> count();
                $hotel_review['count_dislike'] = $hotel_review -> likeReviews() -> wherePivot('is_like', 0) -> count();

                $images = ImageGetHelper::imageGetHelper($hotel_review);
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

                $avatar = Image::find($user->avatar_id);

                if(!$avatar) {
                    $hotel_review['user_avatar'] = null;
                } else {
                    $hotel_review['user_avatar'] = asset('uploads/' . $avatar->path);
                }

                $hotel_review['images'] = $images;

                array_push($reviews_response, $hotel_review);
            } 
        }

        return $reviews_response;
    }
}