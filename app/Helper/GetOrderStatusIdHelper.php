<?php 

namespace App\Helper;

use App\Models\OrderStatus;

class GetOrderStatusIdHelper {
    public static function getUnpaidOrderStatusId(): int
    {
        return OrderStatus::where('name', '=', 'Unpaid')->firstOrFail()->id;
    }

    public static function getPaidOrderStatusId(): int
    {
        return OrderStatus::where('name', '=', 'Paid')->firstOrFail()->id;
    }

    public static function getProcessingOrderStatusId(): int
    {
        return OrderStatus::where('name', '=', 'Processing')->firstOrFail()->id;
    }

    public static function getCompletedOrderStatusId(): int
    {
        return OrderStatus::where('name', '=', 'Completed')->firstOrFail()->id;
    }

    public static function getCancelledOrderStatusId(): int
    {
        return OrderStatus::where('name', '=', 'Cancelled')->firstOrFail()->id;
    }

    public static function getPendingOrderStatusId(): int
    {
        return OrderStatus::where('name', '=', 'Pending')->firstOrFail()->id;
    }

    public static function getConvertedOrderStatusId(): int
    {
        return OrderStatus::where('name', '=', 'Converted')->firstOrFail()->id;
    }

    public static function getAwaitingFeedbackOrderStatusId(): int
    {
        return OrderStatus::where('name', '=', 'Awaiting Feedback')->firstOrFail()->id;
    }

    public static function getUnderDevelopmentOrderStatusId(): int
    {
        return OrderStatus::where('name', '=', 'Under Development')->firstOrFail()->id;
    }

    public static function getErrorOrderStatusId(): int
    {
        return OrderStatus::where('name', '=', 'Error')->firstOrFail()->id;
    }
}