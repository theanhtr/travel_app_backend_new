<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Image;
use App\Http\Requests\StoreMutipleImageRequest;
use App\Http\Requests\StoreImageRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateImageRequest;
use App\Models\TypeRoom;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helper\GetRoleImageIdHelper;
use App\Helper\SplitIdInString;
use App\Http\Requests\DeleteImagesRequest;

class ImageController extends Controller
{
    use HttpResponse;
    /**
     * Display a listing of the resource.
     */
    public function upload(StoreImageRequest $request, $role_image_id, $hotel_id = null, $type_room_id = null) {
        $user = Auth::user();

        /**
         * @var User $user
         */

        $this->authorize('create', Image::class);

        $image = $request->file('image');
        $imageName = Str::random(32) . '_' . time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('uploads'), $imageName);
        // asset('uploads' . $imageName)
        $imageResult = $user->images()->create([
            'path' => $imageName,
            'role_image_id' => $role_image_id,
            'hotel_id' => $hotel_id,
            'type_room_id' => $type_room_id
        ]);

        return $imageResult;
    }

    public function uploadMutipleImage(StoreMutipleImageRequest $request, $role_image_id, $hotel_id = null, $type_room_id = null) {
        $user = Auth::user();

        /**
         * @var User $user
         */

        $this->authorize('create', Image::class);

        $images = $request->file('images');
        $imagesResult = array();

        foreach($images as $image) {
            $imageName = Str::random(32) . '_' . time() . '_' . $image->getClientOriginalName();

            $image->move(public_path('uploads'), $imageName);

            $imageTemp = $user->images()->create([
                'path' => $imageName,
                'role_image_id' => $role_image_id,
                'hotel_id' => $hotel_id,
                'type_room_id' => $type_room_id
            ]);

            array_push($imagesResult, $imageTemp);
        }

        return $imagesResult;
    }

    public function show($image_id) {
        $image = Image::find($image_id);

        if(!$image) {
            return response()->json([
                'message' => "Image not found !!!"
            ], 400);
        }

        $this->authorize('view', $image);

        return response()->json([
            'message' => "Get image complete",
            "path" => asset('uploads/' . $image->path)
        ], 200);
    }

    public function destroy($image_id)
    {
        $image = Image::find($image_id);

        if(!$image) {
            return response()->json([
                'message' => "Image not found !!!"
            ], 400);
        }

        $this->authorize('delete', $image);

        Image::destroy($image->id);

        return response()->json([
            'message' => "Delete image complete"
        ], 200);
    }
    
    public function index() {
        $this->authorize('viewAny', Image::class);

        $images = Image::all();
        return response()->json(["status" => "success", "count" => count($images), "data" => $images]);
    }

    //user avatar
    public function showMyAvatar() {
        $user = Auth::user();

        /**
         * @var User $user
         */

        $image = Image::find($user->avatar_id);

        if(!$image) {
            return $this->failure("Avatar not set");
        }

        $this->authorize('view', $image);

        return $this->success("Get image complete", ["path" => asset('uploads/' . $image->path)]);
    }

    public function uploadMyAvatar(StoreImageRequest $request) {
        $user = Auth::user();

        /**
         * @var User $user
         */

        $image = $this->upload($request, GetRoleImageIdHelper::getAvatarRoleImageId());

        if ($user -> avatar_id) {
            $user->images()->find($user->avatar_id)->delete();
        }

        $user -> avatar_id = $image -> id;
        $user -> save();

        return $this->success('Set avatar success');
    }

    public function deleteMyAvatar() {
        $user = Auth::user();

        /**
         * @var User $user
         */

        $image = Image::find($user->avatar_id);

        if(!$image) {
            return $this->failure("Avatar not set");
        }

        $this->authorize('delete', $image);

        Image::destroy($image->id);

        $user -> avatar_id = null;
        $user -> save();

        return $this->success('Delete avatar success');
    }

    //hotel images
    public function showHotelImages() {
        $user = Auth::user();
        
        /**
         * @var User $user
         */

        $myHotel = $user->hotel()->first();
        
        if(!$myHotel) {
            return $this->failure('Hotel of manager isnt exist');
        }

        /**
         * @var Hotel $myHotel
         */

        $images = $myHotel -> images()->get();

        $imagesResponse = array();

        foreach($images as $image) {
            $image_temp = array();
            $image_temp["id"] = $image->id;
            $image_temp["path"] = asset('uploads/' . $image->path);
            array_push($imagesResponse, $image_temp);
        }

        return $this->success("Get image complete", $imagesResponse);
    }

    public function uploadHotelImages(StoreMutipleImageRequest $request) {
        $user = Auth::user();

        /**
         * @var User $user
         */

        $myHotel = $user->hotel()->first();

        /**
         * @var Hotel $myHotel
         */

        if(!$myHotel) {
            return $this->failure('Hotel of manager isnt exist');
        }
        
        $this->uploadMutipleImage($request, GetRoleImageIdHelper::getHotelRoleImageId(), $myHotel -> id);

        return $this->success('Upload images completed');
    }

    public function deleteHotelImages(DeleteImagesRequest $request) {
        $user = Auth::user();

        /**
         * @var User $user
         */

        $myHotel = $user->hotel();

        /**
         * @var Hotel $myHotel
        */

        if(!$myHotel) {
            return $this->failure("Hotel of manager isn't exist");
        }

        $images_id = SplitIdInString::splitIdInString($request->images_id);

        foreach($images_id as $image_id) {
            $image = Image::find($image_id);
            $this->authorize('deleteHotelImages', $image);
        }

        foreach($images_id as $image_id) {
            $image = Image::find($image_id);
            $image->delete();
        }

        return $this->success('Delete images success');
    }

    //type room images
    public function showTypeRoomImages($type_room_id) {
        $user = Auth::user();
        
        /**
         * @var User $user
         */

        $myHotel = $user->hotel()->first();
        
        if(!$myHotel) {
            return $this->failure('Hotel of manager isnt exist');
        }

        /**
         * @var Hotel $myHotel
         */

        $typeRoom = $myHotel -> typeRooms()->find($type_room_id);

        /**
         * @var TypeRoom $typeRoom
         */

         if(!$typeRoom) {
            return $this->failure('Type room isnt exist');
        }

        $images = $typeRoom -> images()->get();

        $imagesResponse = array();

        foreach($images as $image) {
            $image_temp = array();
            $image_temp["id"] = $image->id;
            $image_temp["path"] = asset('uploads/' . $image->path);
            array_push($imagesResponse, $image_temp);
        }

        return $this->success("Get image complete", $imagesResponse);
    }

    public function uploadTypeRoomImages($type_room_id, StoreMutipleImageRequest $request) {
        $user = Auth::user();

        /**
         * @var User $user
         */

        $myHotel = $user->hotel()->first();

        /**
         * @var Hotel $myHotel
         */

        if(!$myHotel) {
            return $this->failure('Hotel of manager isnt exist');
        }

        $typeRoom = $myHotel -> typeRooms()->find($type_room_id);

        /**
         * @var TypeRoom $typeRoom
         */

        if(!$typeRoom) {
            return $this->failure('Type room isnt exist');
        }
        
        $this->uploadMutipleImage($request, GetRoleImageIdHelper::getHotelRoomRoleImageId(), null, $typeRoom -> id);

        return $this->success('Upload images completed');
    }

    public function deleteTypeRoomImages($type_room_id, DeleteImagesRequest $request) {
        $user = Auth::user();

        /**
         * @var User $user
         */

        $myHotel = $user->hotel();

        /**
         * @var Hotel $myHotel
        */

        if(!$myHotel) {
            return $this->failure("Hotel of manager isn't exist");
        }

        $images_id = SplitIdInString::splitIdInString($request->images_id);

        $typeRoom = $myHotel -> typeRooms()->find($type_room_id);

        /**
         * @var TypeRoom $typeRoom
         */

        if(!$typeRoom) {
            return $this->failure('Type room isnt exist');
        }

        foreach($images_id as $image_id) {
            $image = Image::find($image_id);
            $this->authorize('deleteTypeRoomImages', [$image, $typeRoom->id]);
        }

        foreach($images_id as $image_id) {
            $image = Image::find($image_id);
            $image->delete();
        }

        return $this->success('Delete images success');
    }
}