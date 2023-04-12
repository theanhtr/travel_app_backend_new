<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreHotelOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules()
    {
        return [
            'customer_name' => 'required|string',
            'email_contact' => 'required|email',
            'phone_number_contact' => 'required|numeric',
            'customer_note' => 'string',
            'total_price' => 'required|numeric|gte:0',
            'amount_of_people' => 'required|numeric|gte:0',
            'time_order' => 'required|date|after_or_equal:now',
            'room_quantity' => 'required|numeric|gte:0|lte:amount_of_people',
            'check_in_date' => 'required|date|after_or_equal:now',
            'check_out_date' => 'required|date|after_or_equal:check_in_date',
            'type_room_id' => 'required|numeric',
            'hotel_id' => 'required|numeric'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Invalid input parameter structure',
            'data'      => $validator->errors()
        ], 500));
    }
}
