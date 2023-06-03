<?php

namespace App\Http\Controllers;

use App\Helper\CheckRoomIsAvailablity;
use App\Helper\GetOrderStatusIdHelper;
use App\Helper\HotelOrderHelper;
use App\Models\Hotel;
use App\Models\Order;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\StorePaymentClientRequest;
use App\Http\Requests\StoreHotelOrderRequest;
use App\Http\Requests\HotelOrderCancelRequest;
use App\Models\OrderStatus;
use App\Models\TypeRoom;
use App\Models\User;
use App\Traits\HttpResponse;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            'total_price' => $typeRoom -> price * $request -> room_quantity,
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

        $order -> save();

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
            $order['order_id'] = $order -> id;

            $hotel = Hotel::find($order -> hotel_id);
            $order['hotel_name'] = $hotel -> name;
            
            $type_room = TypeRoom::find($order -> type_room_id);
            $order['type_room_name'] = $type_room -> name;
            $order['type_room_size'] = $type_room -> room_size;
            $order['type_room_number_of_beds'] = $type_room -> number_of_beds;
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
        $order['order_id'] = $order -> id;

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

    public function payment(StorePaymentRequest $request) {
        $user = Auth::user();
        /**
         * @var User $user
         */

        $order = $user -> orders() -> find($request -> order_id);
        /**
         * @var Order $order
         */
        
        if(!$order) {
            return $this -> failure('Order not found');
        }

        if($order -> order_status_id != GetOrderStatusIdHelper::getUnpaidOrderStatusId()) {
            return $this -> failure('Order status not true');
        }

        if($order -> time_order < now()) {
            return $this -> failure('Payment timeout');
        }

        try {
            $stripe = new \Stripe\StripeClient(
                env('STRIPE_SECRET')
            );

            $token = $stripe -> tokens -> create([
                'card' => [
                    'name' => $request -> name_holder_card,
                    'address_country' => 'VN',
                    'address_city' => $request -> address_city,
                    'number' => $request -> number,
                    'exp_month' =>$request -> exp_month,
                    'exp_year' => $request -> exp_year,
                    'cvc' => $request -> cvc,
                ]
            ]);
            
            $userStripe = $user -> createOrGetStripeCustomer();
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            
            $bill = $stripe -> charges -> create([
                'amount' => $order -> total_price * 100,
                'currency' => 'usd',
                'source' => $token -> id,
                'description' => 'test',
            ]);
            
            $order -> order_status_id = 2;
            $order -> payment_id = $bill -> id;
            $order -> save();
            
            return $this->success('ok', $order);
        } catch (\Exception $e) {
            return $this->failure($e->getMessage());
        }
    }

    public function paidHotelCancel($order_id) {
        $user = Auth::user();
        /**
         * @var User $user
         */

        $order = $user -> orders() -> find($order_id);
        /**
         * @var Order $order
         */

        if(!$order) {
            return $this->failure('Order not found');
        }

        if($order -> order_status_id != GetOrderStatusIdHelper::getPaidOrderStatusId()) {
            return $this->failure('Order status is not paid');
        }
        
        //refund
        try {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $refund = \Stripe\Refund::create([
                'charge' => $order -> payment_id,
                'amount' => $order -> total_price * 100,
            ]);
    
            HotelOrderHelper::cancelHotelOrder($order);

            $order['order_id'] = $order -> id;
            $order -> save();
            
            return $this->success('Order canceled', $order);
        } catch (\Exception $e) {
            return $this->failure($e->getMessage());
        }
    }

    public function ordersNeedReview() {
        $user = Auth::user();
        /**
         * @var User $user
         */

        $orders_need_review = $user -> orders() -> where('order_status_id', '=', GetOrderStatusIdHelper::getAwaitingFeedbackOrderStatusId()) -> get();
        foreach($orders_need_review as $order) {
            $order['order_status_name'] = OrderStatus::find($order->order_status_id)->name;
            $order['order_id'] = $order -> id;
        }

        return $this->success('Get ok', $orders_need_review);
    }

    public function paymentClient(StorePaymentClientRequest $request) {
        $user = Auth::user();
        /**
         * @var User $user
         */

        $order = $user -> orders() -> find($request -> order_id);
        /**
         * @var Order $order
         */
        
        if(!$order) {
            return $this -> failure('Order not found');
        }

        if($order -> order_status_id != GetOrderStatusIdHelper::getUnpaidOrderStatusId()) {
            return $this -> failure('Order status not true');
        }

        if($order -> time_order < now()) {
            return $this -> failure('Payment timeout');
        }

        $order -> order_status_id = 2;
        $order -> save();
        
        return $this->success("Payment successfully");
    }

    public function orderStatistic() {
        $user = Auth::user();
        /**
         * @var User $user
         */

        $this->authorize('viewOrderStatistic', Order::class);
        
        $sumWithMonth = DB::table('orders') 
                            ->select(DB::raw("DATE_FORMAT(check_in_date, '%m-%Y') AS month_year, SUM(total_price) as total_payment"))
                            ->groupBy('month_year')
                            ->get();
        
        return $this->success('ok', $sumWithMonth);
    }
}