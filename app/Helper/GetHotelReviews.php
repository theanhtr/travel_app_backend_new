<?php 

namespace App\Helper;

use App\Models\Hotel;
use App\Models\Image;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Database\Eloquent\Collection;

class GetHotelReviews {
    use HttpResponse;
    public static function getHotelReviews(Hotel $hotel)
    {
        $hotel_reviews = $hotel -> reviews() -> get();

        foreach($hotel_reviews as $hotel_review) {
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
        }

        return $hotel_reviews;
    }
}