<?php

namespace App\Http\Controllers;

use App\Helper\CheckRoomIsAvailablity;
use App\Helper\GetOrderStatusIdHelper;
use App\Models\Hotel;
use App\Models\Order;
use App\Http\Requests\StoreHotelOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\User;
use App\Traits\HttpResponse;
use DateTime;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    use HttpResponse;
    public function createHotelOrder(StoreHotelOrderRequest $request) {
        $user = Auth::user();
        /**
         * @var User $user
         */
        $this->authorize('create', Order::class);

        $hotel = Hotel::find($request -> hotel_id);

        if(!$hotel) {
            return $this->failure("Hotel not found");
        }

        $typeRoom = $hotel -> typeRooms() -> find($request -> type_room_id);

        if(!$typeRoom) {
            return $this->failure("Type Room Not Found");
        }

        $rooms = $typeRoom -> rooms() -> get();
        $room = null;

        $time_order = new DateTime($request->time_order);
        $check_in_date = new DateTime($request->check_in_date);
        $check_out_date = new DateTime($request->check_out_date);

        foreach($rooms as $room_temp) {
            if(CheckRoomIsAvailablity::checkRoomIsAvailablity($room_temp, $check_in_date, $check_out_date)) {
                $room = $room_temp;
                break;
            }
        }

        if(!$room) {
            return $this->failure("No available rooms found");
        }
         
        $order = $user -> orders() -> create([
            'customer_name' => $request->customer_name,
            'email_contact' => $request->email_contact,
            'phone_number_contact' => $request->phone_number_contact,
            'customer_note' => $request->customer_note ?? null,
            'total_price' => $request->total_price,
            'amount_of_people' => $request->amount_of_people,
            'time_order' => $time_order,
            'room_quantity' => $request->room_quantity,
            'check_in_date' => $check_in_date,
            'check_out_date' => $check_out_date,
            'type_room_id' => $request->type_room_id,
            'hotel_id' => $request->hotel_id,
            'room_id' => $room -> id,
            'order_status_id' => GetOrderStatusIdHelper::getUnpaidOrderStatusId()
        ]);

        $room -> roomReservationTimes() -> create([
            'check_in_date' => $check_in_date,
            'check_out_date' => $check_out_date
        ]);

        return $this->success('Create order complete, waiting payment', $order);
    }    
}
