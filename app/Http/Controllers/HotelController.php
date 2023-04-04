<?php

namespace App\Http\Controllers;

use App\Helper\GetRoleIdHelper;
use App\Helper\SplitIdInString;
use App\Http\Requests\StoreUserAmenitiesRequest;
use App\Models\Address;
use App\Models\Hotel;
use App\Http\Requests\StoreHotelRequest;
use App\Http\Requests\UpdateHotelRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Hotel::class);

        return response()->json(Hotel::all(), 200);
    }

    public function showOneHotel($hotel_id)
    {
        $hotel = Hotel::find($hotel_id);

        if(!$hotel) {
            return response()->json(["message" => "Hotel not found"], 400);
        }

        $this->authorize('view', $hotel);

        return response()->json($hotel, 200);
    }

    public function deleteHotel($hotel_id)
    {
        $hotel = Hotel::find($hotel_id);

        if(!$hotel) {
            return response()->json(["message" => "Hotel not found"], 400);
        }

        $this->authorize('delete', $hotel);

        Hotel::destroy($hotel->id);

        return response()->json([
            'message' => "Delete complete"
        ], 200);
    }

    public function showMe()
    {
        $user = Auth::user();
        
        $myHotel = Hotel::where('user_id', $user->id)->first();

        if(!$myHotel) {
            return response()->json([
                'error' => 'Hotel of manager isnt exist'
            ], 400);
        }

        $this->authorize('view', $myHotel);

        return response()->json($myHotel, 200);
    }

    public function createMe(StoreHotelRequest $request) 
    {
        $this->authorize('create', Hotel::class);
        
        $user = Auth::user();
        /**
         * @var User $user
         */

        if(Hotel::where('user_id', $user->id)->first()) {
            return response()->json([
                'error' => 'Hotel of manager is exist'
            ], 400);
        }

        $address = Address::create([
            'specific_address' => $request->specific_address ?? null,
            'province_id' => $request->province_id,
            'district_id' => $request->district_id,
            'sub_district_id' => $request->sub_district_id,
        ]);

        $user->hotel()->create([
            'name' => $request->name,
            'description' => $request->description ?? null,
            'address_id' => $address->id,
        ]);

        return response()->json([
            'message' => 'Hotel is stored'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateMe(UpdateHotelRequest $request)
    {
        $user = Auth::user();
        $myHotel = Hotel::where('user_id', $user->id)->first();

        if(!$myHotel) {
            return response()->json([
                'error' => 'Hotel of manager isnt exist'
            ], 400);
        }

        $this->authorize('update', $myHotel);

        if($request->change_address) {
            $oldAddress = $myHotel->address()->get();

            $address = Address::create([
                'specific_address' => $request->specific_address ?? $oldAddress->specific_address,
                'province_id' => $request->province_id ?? $oldAddress->province_id,
                'district_id' => $request->district_id ?? $oldAddress->district_id,
                'sub_district_id' => $request->sub_district_id ?? $oldAddress->sub_district_id,
            ]);

            $myHotel -> address_id = $address -> id;
        }

        if($request->name) {
            $myHotel->name = $request->name;
        }

        if($request->description) {
            $myHotel->description = $request->description;
        }

        $myHotel->save();

        return response()->json([
            'message' => 'Hotel is updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyMe()
    {
        $user = Auth::user();
        $myHotel = Hotel::where('user_id', $user->id)->first();

        if(!$myHotel) {
            return response()->json([
                'error' => 'Hotel of manager isnt exist'
            ], 400);
        }
        
        $this->authorize('delete', $myHotel);

        Hotel::destroy($myHotel->id);
        Address::destroy($myHotel->address_id);
        return response()->json([
            'message' => "Delete complete"
        ], 200);
    }

    public function showAmenities() {
        $user = Auth::user();
        
        $myHotel = Hotel::where('user_id', $user->id)->first();

        if(!$myHotel) {
            return response()->json([
                'error' => 'Hotel of manager isnt exist'
            ], 400);
        }

        $this->authorize('view', $myHotel);

        $amnities = $myHotel->amenities()->get();

        return response()->json([
            $amnities
        ], 200);
    }

    public function addAmenities(StoreUserAmenitiesRequest $request) {
        $user = Auth::user();

        $myHotel = Hotel::where('user_id', $user->id)->first();

        if(!$myHotel) {
            return response()->json([
                'error' => 'Hotel of manager isnt exist'
            ], 400);
        }

        $this->authorize('createAmenities', $myHotel);

        $id_amenities = SplitIdInString::splitIdInString($request->amenities);

        $myHotel -> amenities() -> syncWithoutDetaching($id_amenities);

        return response()->json([
            "success"
        ], 200);
    }

    public function deleteAmenities(StoreUserAmenitiesRequest $request) {
        $user = Auth::user();

        $myHotel = Hotel::where('user_id', $user->id)->first();

        if(!$myHotel) {
            return response()->json([
                'error' => 'Hotel of manager isnt exist'
            ], 400);
        }

        $this->authorize('createAmenities', $myHotel);

        $id_amenities = SplitIdInString::splitIdInString($request->amenities);
        
        $myHotel -> amenities() -> detach($id_amenities);

        return response()->json([
            "delete success"
        ], 200);
    }
}
