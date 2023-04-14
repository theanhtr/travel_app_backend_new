<?php 

namespace App\Helper;

use App\Models\Order;
use App\Traits\HttpResponse;

class HotelOrderHelper {
    public static function cancelHotelOrder(Order $order)
    {
        $order -> rooms() -> detach();
        $order -> roomReservationTimes -> each(function($roomReservationTime) {
            $roomReservationTime->delete();
        });

        $order -> order_status_id = GetOrderStatusIdHelper::getCancelledOrderStatusId();
        $order -> save();
    }

    public static function getOrder($order_id) {
        $order = Order::find($order_id);
        /**
         * @var Order $order
         */

        if(!$order) {
            return null;
        }

        return $order;
    }

    public static function getAllOrder() {
        return Order::all();
    }

    public static function transitionToUnpaidCanceled($order_id) {
        $order = HotelOrderHelper::getOrder($order_id);

        if($order -> order_status_id != GetOrderStatusIdHelper::getUnpaidOrderStatusId()) {
            return null;
        }

        HotelOrderHelper::cancelHotelOrder($order);
    }

    public static function transitionToAwaitFeedback($order_id) {
        $order = HotelOrderHelper::getOrder($order_id);

        if($order -> order_status_id != GetOrderStatusIdHelper::getPaidOrderStatusId()) {
            return null;
        }

        $order -> rooms() -> detach();
        $order -> roomReservationTimes -> each(function($roomReservationTime) {
            $roomReservationTime->delete();
        });

        $order -> order_status_id = GetOrderStatusIdHelper::getAwaitingFeedbackOrderStatusId();
        $order -> save();
    }

    public static function transitionToCompleted($order_id) {
        $order = HotelOrderHelper::getOrder($order_id);

        if($order -> order_status_id != GetOrderStatusIdHelper::getAwaitingFeedbackOrderStatusId()) {
            return null;
        }

        $order -> order_status_id = GetOrderStatusIdHelper::getCompletedOrderStatusId();
        $order -> save();
    }
}