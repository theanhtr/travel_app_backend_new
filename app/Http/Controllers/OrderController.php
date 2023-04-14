<?php

namespace App\Http\Controllers;

use App\Helper\CheckRoomIsAvailablity;
use App\Helper\GetOrderStatusIdHelper;
use App\Helper\HotelOrderHelper;
use App\Models\Hotel;
use App\Models\Order;
use App\Http\Requests\StoreHotelOrderRequest;
use App\Http\Requests\HotelOrderCancelRequest;
use App\Models\OrderStatus;
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
        $rooms_book = array();

        $check_in_date = new DateTime($request->check_in_date);
        $check_out_date = new DateTime($request->check_out_date);

        $room_quantity = $request -> room_quantity;

        foreach($rooms as $room_temp) {
            if(CheckRoomIsAvailablity::checkRoomIsAvailablity($room_temp, $check_in_date, $check_out_date)) {
                array_push($rooms_book, $room_temp);
                $room_quantity--;
                if ($room_quantity == 0) {
                    break;
                }
            }
        }

        if(!$rooms_book) {
            return $this->failure("No available rooms found");
        }

        $order = $user -> orders() -> create([
            'customer_name' => $request->customer_name,
            'email_contact' => $request->email_contact,
            'phone_number_contact' => $request->phone_number_contact,
            'customer_note' => $request->customer_note ?? null,
            'total_price' => $request->total_price,
            'amount_of_people' => $request->amount_of_people,
            'time_order' => new DateTime(now()->addMinutes(15)),
            'room_quantity' => $request->room_quantity,
            'check_in_date' => $check_in_date,
            'check_out_date' => $check_out_date,
            'type_room_id' => $request->type_room_id,
            'hotel_id' => $request->hotel_id,
            'order_status_id' => GetOrderStatusIdHelper::getUnpaidOrderStatusId()
        ]);

        foreach($rooms_book as $room) {
            $order -> rooms() -> attach($room -> id);
            $room -> roomReservationTimes() -> create([
                'check_in_date' => $check_in_date,
                'check_out_date' => $check_out_date,
                'order_id' => $order->id
            ]);
        }

        return $this->success('Create order complete, waiting payment', $order);
    }

    public function getAllHotelOrder() {
        $user = Auth::user();
        /**
         * @var User $user
         */

        $orders = $user->orders()->get();

        foreach($orders as $order) {
            $order['order_status_name'] = OrderStatus::find($order->order_status_id)->name;
        }

        return $this->success('Get all complete', $orders);
    }

    public function showHotelOrder($order_id) {
        $user = Auth::user();
        /**
         * @var User $user
         */

        $order = $user -> orders() -> find($order_id);
        /**
         * @var Order $order
         */

        if(!$order) {
            return $this->failure('Order not exist');
        }

        $order['order_status_name'] = OrderStatus::find($order->order_status_id)->name;

        return $this->success('Get complete', $order);
    }

    public function unpaidHotelCancel($order_id) {
        $user = Auth::user();
        /**
         * @var User $user
         */

        $order = $user -> orders() -> find($order_id);
        /**
         * @var Order $order
         */

        if(!$order) {
            return $this->failure('Order not exist');
        }

        if($order -> order_status_id != GetOrderStatusIdHelper::getUnpaidOrderStatusId()) {
            return $this->failure('Order status is not unpaid');
        }

        $this->authorize('update', $order);

        HotelOrderHelper::cancelHotelOrder($order);

        return $this->success('Order canceled');
    }

    public function payment() {

    }

    public function paidCancel() {

    }

    public function ordersNeedReview() {
        $user = Auth::user();
        /**
         * @var User $user
         */

        $orders_need_review = $user -> orders() -> where('order_status_id', '=', GetOrderStatusIdHelper::getAwaitingFeedbackOrderStatusId()) -> get();

        return $this->success('Get ok', $orders_need_review);
    }
}
