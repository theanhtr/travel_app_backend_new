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
        $user = Auth::user();
        /**
         * @var User $user
         */

        $populars_destination = PopularDestination::all();

        foreach($populars_destination as $popular_destination) {
            $popular_destination['image_path'] = asset('images/popular_destination/' . $popular_destination->image_path);
            $popular_destination['province_name'] = Province::find($popular_destination -> province_id)->name ?? 'No name';
            $popular_destination['is_like'] = $user -> popularDestinationsLike() -> find($popular_destination -> id) ? 1 : 0;
        }

        $populars_destination = $populars_destination -> sortByDesc('is_like');

        $populars_destination_response = [];

        foreach ($populars_destination as $value) {
            array_push($populars_destination_response,$value);
        }

        return $this->success('Get popular destination done', $populars_destination_response);
    }
}
