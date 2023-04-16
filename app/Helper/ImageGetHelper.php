<?php 

namespace App\Helper;

use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ImageGetHelper {
    public static function imageGetHelper($object) {
        $images = $object -> images()->get();

        $imagesResponse = array();

        foreach($images as $image) {
            $image_temp = array();
            $image_temp["id"] = $image->id;
            $image_temp["path"] = asset('uploads/' . $image->path);
            array_push($imagesResponse, $image_temp);
        }

        return $imagesResponse;
    }
}