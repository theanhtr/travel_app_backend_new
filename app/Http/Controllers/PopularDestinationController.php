<?php

namespace App\Http\Controllers;

use App\Helper\GetHotelReviews;
use App\Helper\GetOrderStatusIdHelper;
use App\Helper\GetRoleImageIdHelper;
use App\Helper\ImageGetHelper;
use App\Helper\ImageUploadHelper;
use App\Models\Hotel;
use App\Models\Image;
use App\Models\Order;
use App\Models\PopularDestination;
use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Province;
use App\Models\SortBy;
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PopularDestinationController extends Controller
{
    use HttpResponse;
    public function getAll() {
        $populars_destination = PopularDestination::all();

        foreach($populars_destination as $popular_destination) {
            $popular_destination['image_path'] = asset('images/popular_destination/' . $popular_destination->image_path);
            $popular_destination['province_name'] = Province::find($popular_destination -> province_id)->name ?? 'No name';
        }

        return $this->success('Get popular destination done', $populars_destination);
    }
}
