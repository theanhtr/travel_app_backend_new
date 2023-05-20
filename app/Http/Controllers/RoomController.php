<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\DeleteRoomRequest;
use App\Models\TypeRoom;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    use HttpResponse;
    public function addRooms(StoreRoomRequest $request) {
        $user = Auth::user();

        $myHotel = Hotel::where('user_id', $user->id)->first();

        if(!$myHotel) {
            return $this->failure('Hotel of manager isnt exist');
        }

        $typeRoom = TypeRoom::find($request->type_room_id);

        if(!$typeRoom) {
            return $this->failure('Type room isnt exist');
        }

        $this->authorize('typeRoom', [$myHotel, $typeRoom]);

        for($i = 0; $i < $request -> quantity; $i ++) {
            $typeRoom -> rooms() -> create([
                "created_at" => now()
            ]);
        }
        
        $typeRoom -> save();

        return $this->success('Room is stored');
    }

    // public function deleteRooms(DeleteRoomRequest $request) {
    //     $user = Auth::user();

    //     $myHotel = Hotel::where('user_id', $user->id)->first();

    //     if(!$myHotel) {
    //         return response()->json([
    //             'error' => 'Hotel of manager isnt exist'
    //         ], 400);
    //     }

    //     $typeRoom = TypeRoom::find($request->type_room_id);

    //     if(!$typeRoom) {
    //         return response()->json([
    //             'error' => 'Type room isnt exist'
    //         ], 400);
    //     }

    //     $this->authorize('typeRoom', [$myHotel, $typeRoom]);

    //     for($i = 0; $i < $request -> quantity; $i ++) {
    //         $typeRoom -> rooms() -> create([
    //             "availablity" => true
    //         ]);
    //     }

    //     $typeRoom -> save();

    //     return response()->json([
    //         'message' => 'Room is stored'
    //     ], 200);
    // }
}