<?php

namespace App\Http\Controllers;

use App\Helper\SplitIdInString;
use App\Http\Requests\StoreUserAmenitiesRequest;
use App\Models\Hotel;
use App\Models\TypeRoom;
use App\Http\Requests\StoreTypeRoomRequest;
use App\Http\Requests\UpdateTypeRoomRequest;
use App\Http\Requests\UpdateTypeRoomPriceRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TypeRoomController extends Controller
{
    public function showAllTypeRoom()
    {
        $user = Auth::user();
        
        /**
         * @var User $user
         */
        
        $myHotel = Hotel::where('user_id', $user->id)->first();

        if(!$myHotel) {
            return response()->json([
                'error' => 'Hotel of manager isnt exist'
            ], 400);
        }

        $this->authorize('view', $myHotel);

        $typeRooms = $myHotel->typeRooms()->get();

        $typeRoomsAmenities = array();

        foreach($typeRooms as $typeRoom) {
            $amenities = $typeRoom->amenities()->get();
            $typeRoomsAmenities[$typeRoom->id] = $amenities;
        }

        return response()->json([
            'data' => [
                'type room' => $typeRooms,
                'amenities' => $typeRoomsAmenities
            ]
        ], 200);
    }

    public function showTypeRoom($type_room_id)
    {
        $user = Auth::user();
        
        /**
         * @var User $user
         */
        
        $myHotel = Hotel::where('user_id', $user->id)->first();

        if(!$myHotel) {
            return response()->json([
                'error' => 'Hotel of manager isnt exist'
            ], 400);
        }

        $this->authorize('view', $myHotel);

        $typeRoom = TypeRoom::find($type_room_id);

        if(!$typeRoom) {
            return response()->json([
                'error' => 'Type room isnt exist'
            ], 400);
        }

        $this->authorize('typeRoom', [$myHotel, $typeRoom]);

        $typeRoomAmenities = $typeRoom -> amenities() -> get();

        return response()->json([
            'data' => [
                'type room' => $typeRoom,
                'amenities' => $typeRoomAmenities
            ]
        ], 200);
    }

    public function addTypeRoom(StoreTypeRoomRequest $request) 
    {
        $user = Auth::user();
        /**
         * @var User $user
         */
        
        $myHotel = Hotel::where('user_id', $user->id)->first();
        
        if(!$myHotel) {
            return response()->json([
                'error' => 'Hotel of manager isnt exist'
            ], 400);
        }
        
        $this->authorize('createTypeRoom', $myHotel);

        $typeRoom = $myHotel->typeRooms()->create([
            'name' => $request->name,
            'description' => $request->description ?? null,
            'price' => $request->price,
            'occupancy' => $request->occupancy,
        ]);

        $this->syncAmenities($myHotel, $typeRoom, $request -> amenities);

        return response()->json([
            'message' => 'Type room of hotel is stored'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateTypeRoom($type_room_id, UpdateTypeRoomRequest $request)
    {
        $user = Auth::user();

        $myHotel = Hotel::where('user_id', $user->id)->first();

        if(!$myHotel) {
            return response()->json([
                'error' => 'Hotel of manager isnt exist'
            ], 400);
        }

        $typeRoom = TypeRoom::find($type_room_id);

        if(!$typeRoom) {
            return response()->json([
                'error' => 'Type room isnt exist'
            ], 400);
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

        $typeRoom->save();

        $this->syncAmenities($myHotel, $typeRoom, $request -> amenities);

        return response()->json([
            'message' => 'Type room is updated'
        ], 200);
    }

    public function updateTypeRoomPrice($type_room_id, UpdateTypeRoomPriceRequest $request)
    {
        $user = Auth::user();

        $myHotel = Hotel::where('user_id', $user->id)->first();

        if(!$myHotel) {
            return response()->json([
                'error' => 'Hotel of manager isnt exist'
            ], 400);
        }

        $typeRoom = TypeRoom::find($type_room_id);

        if(!$typeRoom) {
            return response()->json([
                'error' => 'Type room isnt exist'
            ], 400);
        }

        $this->authorize('typeRoom', [$myHotel, $typeRoom]);

        $typeRoom->price = $request->price;

        $typeRoom->save();

        return response()->json([
            'message' => 'Price of type room is updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteTypeRoom($type_room_id)
    {
        $user = Auth::user();

        $myHotel = Hotel::where('user_id', $user->id)->first();

        if(!$myHotel) {
            return response()->json([
                'error' => 'Hotel of manager isnt exist'
            ], 400);
        }
        
        $typeRoom = TypeRoom::find($type_room_id);

        if(!$typeRoom) {
            return response()->json([
                'error' => 'Type room isnt exist'
            ], 400);
        }

        $this->authorize('typeRoom', [$myHotel, $typeRoom]);
        
        $typeRoom->delete();

        return response()->json([
            'message' => "Delete type room complete"
        ], 200);
    }

    public function syncAmenities(Hotel $myHotel, TypeRoom $typeRoom, String $amenities) 
    {
        $this->authorize('typeRoom', [$myHotel, $typeRoom]);

        $id_amenities = SplitIdInString::splitIdInString($amenities);

        $typeRoom -> amenities() -> sync($id_amenities);
    }
}
