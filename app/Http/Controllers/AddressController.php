<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\District;
use App\Models\Hotel;
use App\Models\Province;
use App\Models\SubDistrict;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    use HttpResponse;
    public function showMyHotelAddress() {
        $user = Auth::user();

        /**
         * @var User $user
         */

        if(!$user->hotel()->exists()) {
            return $this->failure("Hotel of manager isnt exist");
        }
        
        $hotel = $user->hotel()->first();
        
        /**
         * @var Hotel $hotel
         */
        $address = Address::find($hotel -> address_id);

        if(!$address) {
            return $this->failure("Address not register");
        }

        $addressResponse = array();
        $addressResponse['specific_address'] = $address -> specific_address;
        $addressResponse['province'] = Province::find($address->province_id)->name;
        $addressResponse['district'] = District::find($address->district_id)->name;
        $addressResponse['sub_district'] = SubDistrict::find($address->sub_district_id)->name;

        return $this->success("Get success", $addressResponse);
    }

    public function showProvinces() {
        $provinces = Province::all();
        return $this->success("Get all province success", $provinces);
    }

    public function showDistricts($province_id) {
        $province = Province::find($province_id);
        $districts = $province -> districts() -> get();
        return $this->success("Get all districts of " . $province -> name . " success", $districts);
    }

    public function showSubDistricts($district_id) {
        $district = District::find($district_id);
        $sub_districts = $district->subDistricts()->get();
        return $this->success("Get all sub districts of " . $district -> name . " success", $sub_districts);
    }
}
