<?php

namespace App\Http\Controllers;

use App\Helper\ChangeHotelMinMaxPrice;
use App\Helper\SplitIdInString;
use App\Http\Requests\StoreUserAmenitiesRequest;
use App\Models\Hotel;
use App\Models\TypeRoom;
use App\Http\Requests\StoreTypeRoomRequest;
use App\Http\Requests\UpdateTypeRoomRequest;
use App\Http\Requests\UpdateTypeRoomPriceRequest;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Auth;

class TypeRoomController extends Controller
{
    use HttpResponse;
    public function showAllTypeRoom() {
        $user = Auth::user();
        
        /**
         * @var User $user
         */
        
        $myHotel = Hotel::where('user_id', $user->id)->first();

        if(!$myHotel) {
            return $this->failure('Hotel of manager isnt exist');
        }

        $this->authorize('view', $myHotel);

        $typeRooms = $myHotel->typeRooms()->get();

        foreach($typeRooms as $typeRoom) {
            $amenities = $typeRoom->amenities()->get();
            $typeRoom["amenities"] = $amenities;
            $typeRoom["room_quantity"] = $typeRoom -> rooms() -> count();
        }

        return $this->success('Get complete', $typeRooms);
    }

    public function showTypeRoom($type_room_id) {
        $user = Auth::user();
        
        /**
         * @var User $user
         */
        
        $myHotel = Hotel::where('user_id', $user->id)->first();

        if(!$myHotel) {
            return $this->failure('Hotel of manager isnt exist');
        }

        $this->authorize('view', $myHotel);

        $typeRoom = TypeRoom::find($type_room_id);

        if(!$typeRoom) {
            return $this->failure('Type room isnt exist');
        }

        $this->authorize('typeRoom', [$myHotel, $typeRoom]);

        $typeRoom["amenities"] = $typeRoom -> amenities() -> get();
        
        return $this->success("Get complete", $typeRoom);
    }

    public function addTypeRoom(StoreTypeRoomRequest $request) {
        $user = Auth::user();
        /**
         * @var User $user
         */
        
        $myHotel = Hotel::where('user_id', $user->id)->first();
        
        if(!$myHotel) {
            return $this->failure('Hotel of manager isnt exist');
        }
        
        $this->authorize('createTypeRoom', $myHotel);

        $typeRoom = $myHotel->typeRooms()->create([
            'name' => $request->name,
            'description' => $request->description ?? null,
            'price' => $request->price,
            'occupancy' => $request->occupancy,
            'number_of_beds' => $request->number_of_beds,
            'room_size' => $request->room_size
        ]);

        $this->syncAmenities($myHotel, $typeRoom, $request -> amenities);

        ChangeHotelMinMaxPrice::changeHotelMinMaxPrice($user);

        return $this->success('Type room of hotel is stored', $typeRoom);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateTypeRoom($type_room_id, UpdateTypeRoomRequest $request) {
        $user = Auth::user();
        /**
         * @var User $user
         */
        $myHotel = Hotel::where('user_id', $user->id)->first();

        if(!$myHotel) {
            return $this->failure('Hotel of manager isnt exist');
        }

        $typeRoom = TypeRoom::find($type_room_id);

        if(!$typeRoom) {
            return $this->failure('Type room isnt exist');
        }

        $this->authorize('typeRoom', [$myHotel, $typeRoom]);

        if($request->name) {
            $typeRoom->name = $request->name;
        }

        if($request->description) {
            $typeRoom->description = $request->description;
        }

        if($request->price) {
            $typeRoom->price = $request->price;
        }

        if($request->occupancy) {
            $typeRoom->occupancy = $request->occupancy;
        }

        if($request->number_of_beds) {
            $typeRoom->number_of_beds = $request->number_of_beds;
        }

        if($request->room_size) {
            $typeRoom->room_size = $request->room_size;
        }

        $typeRoom->save();

        $this->syncAmenities($myHotel, $typeRoom, $request -> amenities);

        ChangeHotelMinMaxPrice::changeHotelMinMaxPrice($user);

        return response()->json([
            'message' => 'Type room is updated'
        ], 200);
    }

    public function updateTypeRoomPrice($type_room_id, UpdateTypeRoomPriceRequest $request) {
        $user = Auth::user();
        /**
         * @var User $user
         */
        $myHotel = Hotel::where('user_id', $user->id)->first();

        if(!$myHotel) {
            return $this->failure('Hotel of manager isnt exist');
        }

        $typeRoom = TypeRoom::find($type_room_id);

        if(!$typeRoom) {
            return $this->failure('Type room isnt exist');
        }

        $this->authorize('typeRoom', [$myHotel, $typeRoom]);

        $typeRoom->price = $request->price;

        $typeRoom->save();

        ChangeHotelMinMaxPrice::changeHotelMinMaxPrice($user);

        return $this->success('Price of type room is updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteTypeRoom($type_room_id) {
        $user = Auth::user();
        /**
         * @var User $user
         */
        $myHotel = Hotel::where('user_id', $user->id)->first();

        if(!$myHotel) {
            return $this->failure('Hotel of manager isnt exist');
        }
        
        $typeRoom = TypeRoom::find($type_room_id);

        if(!$typeRoom) {
            return $this->failure('Type room isnt exist');
        }

        $this->authorize('typeRoom', [$myHotel, $typeRoom]);
        
        $typeRoom->delete();

        ChangeHotelMinMaxPrice::changeHotelMinMaxPrice($user);

        return $this->success("Delete type room complete");
    }

    public function syncAmenities(Hotel $myHotel, TypeRoom $typeRoom, String $amenities) {
        $this->authorize('typeRoom', [$myHotel, $typeRoom]);

        $id_amenities = SplitIdInString::splitIdInString($amenities);

        $typeRoom -> amenities() -> sync($id_amenities);
    }
}