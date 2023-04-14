<?php 

namespace App\Helper;

use App\Models\Image;
use App\Models\User;
use App\Traits\HttpResponse;
use App\Http\Requests\StoreMutipleImageRequest;
use App\Http\Requests\StoreImageRequest;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ImageUploadHelper {
    public static function upload($request, $role_image_id, $hotel_id = null, $type_room_id = null, $review_id = null) {
        $user = Auth::user();

        /**
         * @var User $user
         */

        $image = $request->file('image');
        $imageName = Str::random(32) . '_' . time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('uploads'), $imageName);
        
        $imageResult = $user->images()->create([
            'path' => $imageName,
            'role_image_id' => $role_image_id,
            'hotel_id' => $hotel_id,
            'type_room_id' => $type_room_id,
            'review_id' => $review_id,
        ]);

        return $imageResult;
    }

    public static function uploadMutipleImage($request, $role_image_id, $hotel_id = null, $type_room_id = null, $review_id = null) {
        $user = Auth::user();

        /**
         * @var User $user
         */

        $images = $request->file('images');
        $imagesResult = array();

        foreach($images as $image) {
            $imageName = Str::random(32) . '_' . time() . '_' . str_replace(' ', '', $image->getClientOriginalName());

            $image->move(public_path('uploads'), $imageName);

            $imageTemp = $user->images()->create([
                'path' => $imageName,
                'role_image_id' => $role_image_id,
                'hotel_id' => $hotel_id,
                'type_room_id' => $type_room_id,
                'review_id' => $review_id,
            ]);

            array_push($imagesResult, $imageTemp);
        }

        return $imagesResult;
    }
}