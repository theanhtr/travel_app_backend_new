<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Http\Requests\StoreMutipleImageRequest;
use App\Http\Requests\StoreImageRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateImageRequest;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helper\GetRoleImageIdHelper;

class ImageController extends Controller
{
    use HttpResponse;
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $this->authorize('viewAny', Image::class);

        $images = Image::all();
        return response()->json(["status" => "success", "count" => count($images), "data" => $images]);
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

    public function upload(StoreImageRequest $request, $role_image_id) {
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
            'role_image_id' => $role_image_id
        ]);

        return $imageResult;
    }

    public function uploadMutipleImage(StoreMutipleImageRequest $request, $role_image_id) {
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
                'role_image_id' => $role_image_id
            ]);

            array_push($imagesResult, $imageTemp);
        }

        return $imagesResult;
    }

    /**
     * Remove the specified resource from storage.
     */
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
}