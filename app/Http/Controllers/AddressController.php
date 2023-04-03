<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{

    public function showMyHotelAddress()
    {
        $user = Auth::user();

        /**
         * @var User $user
         */

        if(!$user) {
            return response()->json("Need authorization", 400);
        }

        if(!$user->hotel()->exists()) {
            return response()->json("Hotel not found", 400);
        }
        
        $hotel = $user->hotel()->first();
        
        /**
         * @var Hotel $hotel
         */
        $address = Address::find($hotel -> address_id);

        if(!$address) {
            return response()->json("Address not register", 400);
        }

        return response()->json($address, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressRequest $request, Address $address)
    {
        // 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        //
    }
}
