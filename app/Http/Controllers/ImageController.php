<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Http\Requests\StoreMutipleImageRequest;
use App\Http\Requests\StoreImageRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateImageRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $images = Image::all();
        return response()->json(["status" => "success", "count" => count($images), "data" => $images]);
    }

    public function upload(StoreImageRequest $request) {
        $user = Auth::user();

        /**
         * @var User $user
         */

        $image = $request->file('image');
        $imageName = Str::random(32) . '_' . time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('uploads'), $imageName);
        // asset('uploads' . $imageName)
        $image = $user->images()->create([
            'path' => $imageName
        ]);

        if($request -> set_avatar) {
            if ($user -> avatar_id) {
                $user->images()->find($user->avatar_id)->delete();
            }

            $user -> avatar_id = $image -> id;
            $user -> save();
            return response()->json([
                'message' => 'Set avatar success'
            ], 200);
        } else {
            return response()->json([
                'message' => 'File uploaded successfully'
            ], 200);
        }
    }

    public function uploadMutipleImage(StoreMutipleImageRequest $request) {
        $user = Auth::user();

        /**
         * @var User $user
         */

        $images = $request->file('images');
        
        foreach($images as $image) {
            $imageName = Str::random(32) . '_' . time() . '_' . $image->getClientOriginalName();

            $image->move(public_path('uploads'), $imageName);

            $user->images()->create([
                'path' => $imageName
            ]);
        }

        return response()->json([
            'message' => 'File uploaded successfully',
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateImageRequest $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image)
    {
        //
    }
}