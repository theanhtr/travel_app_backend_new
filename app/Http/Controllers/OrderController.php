<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreHotelOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    use HttpResponse;
    public function createHotelOrder(StoreHotelOrderRequest $request) {
        $user = Auth::user();

        
    }    
}
