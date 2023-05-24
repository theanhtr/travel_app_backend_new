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
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Auth;

class HotelController extends Controller
{
    use HttpResponse;
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $this->authorize('viewAny', Hotel::class);

        return $this->success('Get success', Hotel::all());
    }

    public function showOneHotel($hotel_id) {
        $hotel = Hotel::find($hotel_id);

        if(!$hotel) {
            return $this->failure("Hotel not found");
        }

        $this->authorize('view', $hotel);

        $amenities = $hotel -> amenities() -> get();
        
        return $this->success("Get hotel completed", 
        ['hotel' => $hotel,
        'amenities' => $amenities]);
    }

    public function deleteHotel($hotel_id) {
        $hotel = Hotel::find($hotel_id);

        if(!$hotel) {
            return $this->failure("Hotel not found");
        }

        $this->authorize('delete', $hotel);

        $hotel->delete();

        return $this->success("Delete hotel completed");
    }

    public function showMe() {
        $user = Auth::user();
        
        $myHotel = Hotel::where('user_id', $user->id)->first();

        if(!$myHotel) {
            return $this->failure("Hotel of manager isn't exist");
        }

        $this->authorize('view', $myHotel);

        $amenities = $myHotel -> amenities() -> get();

        
        return $this->success("Get hotel completed", 
        ['hotel' => $myHotel,
        'amenities' => $amenities]);
    }

    public function createMe(StoreHotelRequest $request) {
        $this->authorize('create', Hotel::class);
        
        $user = Auth::user();
        /**
         * @var User $user
         */

        if(Hotel::where('user_id', $user->id)->first()) {
            return $this->failure('Hotel of manager is exist');
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

        return $this->success('Hotel is stored');
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateMe(UpdateHotelRequest $request) {
        $user = Auth::user();
        $myHotel = Hotel::where('user_id', $user->id)->first();

        if(!$myHotel) {
            return $this-> failure("Hotel of manager isn't exist");
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

        return $this->success('Hotel is updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyMe() {
        $user = Auth::user();
        $myHotel = Hotel::where('user_id', $user->id)->first();

        if(!$myHotel) {
            return $this->failure("Hotel of manager isn't exist");
        }
        
        $this->authorize('delete', $myHotel);

        $myHotel -> delete();

        return $this->success("Delete complete");
    }

    public function showAmenities() {
        $user = Auth::user();
        
        $myHotel = Hotel::where('user_id', $user->id)->first();

        if(!$myHotel) {
            return $this->failure('Hotel of manager isnt exist');
        }

        $this->authorize('view', $myHotel);

        $amnities = $myHotel->amenities()->get();

        return $this->success('Get success', $amnities);
    }

    public function addAmenities(StoreUserAmenitiesRequest $request) {
        $user = Auth::user();

        $myHotel = Hotel::where('user_id', $user->id)->first();

        if(!$myHotel) {
            return $this->failure('Hotel of manager isnt exist');
        }

        $this->authorize('createAmenities', $myHotel);

        $id_amenities = SplitIdInString::splitIdInString($request->amenities);

        $myHotel -> amenities() -> syncWithoutDetaching($id_amenities);

        return $this->success("Add amenities success");
    }

    public function deleteAmenities(StoreUserAmenitiesRequest $request) {
        $user = Auth::user();

        $myHotel = Hotel::where('user_id', $user->id)->first();

        if(!$myHotel) {
            return $this->failure('Hotel of manager isnt exist');
        }

        $this->authorize('createAmenities', $myHotel);

        $id_amenities = SplitIdInString::splitIdInString($request->amenities);
        
        $myHotel -> amenities() -> detach($id_amenities);

        return $this->success("Delete success");
    }
}