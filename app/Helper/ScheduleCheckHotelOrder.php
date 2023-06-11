<?php 

namespace App\Helper;

use App\Models\Order;
use DateTime;

class ScheduleCheckHotelOrder {
    public static function transitionOrdersStatusToCanceled() {
        $orders = HotelOrderHelper::getAllOrder();
        $now = new DateTime();
        foreach($orders as $order) {
            $time_order = new DateTime($order -> time_order);
            $check_in_date = new DateTime($order -> check_in_date);

            if($time_order -> getTimeStamp() < $now -> getTimestamp()) {
                HotelOrderHelper::transitionToUnpaidCanceled($order->id);
                continue;
            }


            if($check_in_date -> getTimeStamp() < $now -> getTimestamp()) {
                HotelOrderHelper::transitionToUnpaidCanceled($order->id);
            }
        }
    }

    public static function transitionOrdersStatusToAwaitFeedback() {
        $orders = HotelOrderHelper::getAllOrder();
        $now = new DateTime();

        foreach($orders as $order) {
            $check_in_date = new DateTime($order -> check_in_date);

            if($check_in_date -> getTimeStamp() < $now -> getTimestamp() || $order->order_status_id === 2) {
                HotelOrderHelper::transitionToAwaitFeedback($order->id);
            }
        }
    }

    public static function transitionOrdersStatusToCompleted() {
        $orders = HotelOrderHelper::getAllOrder();
        $now = new DateTime();

        foreach($orders as $order) {
            $check_out_date = new DateTime($order -> check_out_date);
            $has_expire_date = $check_out_date -> modify('+7 day');

            if($has_expire_date -> getTimeStamp() < $now -> getTimestamp()) {
                HotelOrderHelper::transitionToCompleted($order->id);
            }
        }
    }
}