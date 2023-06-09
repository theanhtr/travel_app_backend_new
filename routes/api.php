<?php

use App\Http\Controllers\AuthenticationController;
use App\Models\Authentication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

require __DIR__ . '/auth/auth.php';

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/auth/logout', [App\Http\Controllers\Auth\AuthenticationController::class, 'logout']) 
        ->name('auth.logout');

    Route::put('/auth/update-password', [App\Http\Controllers\Auth\AuthenticationController::class, 'updatePassword']) 
        ->name('auth.updatePassword');

    require __DIR__ . '/users/user.php';
    require __DIR__ . '/users/user_information.php';
    require __DIR__ . '/images/image.php';
    require __DIR__ . '/addresses/address.php';
    require __DIR__ . '/hotels/hotel.php';
    require __DIR__ . '/hotels/type_room.php';
    require __DIR__ . '/hotels/room.php';
    require __DIR__ . '/amenities/amenity.php';
    require __DIR__ . '/searches/search.php';
    require __DIR__ . '/searches/filter.php';
    require __DIR__ . '/searches/popular_destination.php';
    require __DIR__ . '/users/user_like.php';
    require __DIR__ . '/orders/review.php';
    require __DIR__ . '/orders/order.php';
    require __DIR__ . '/orders/order.php';
    require __DIR__ . '/messages/message.php';
    require __DIR__ . '/messages/conversation.php';
    require __DIR__ . '/payments/payment.php';
});
