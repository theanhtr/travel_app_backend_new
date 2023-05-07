<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class SearchTypeRoomsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
            //format date: hh:mm:ss mm/dd/yy
            'check_in_date' => 'required|date|after_or_equal:now',
            'check_out_date' => 'required|date|after_or_equal:check_in_date',
            'guest_quantity' => 'required|numeric',
            'room_quantity' => 'required|numeric',
            'hotel_id' => 'required|numeric'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Invalid input parameter structure',
            'data'      => $validator->errors()
        ], 422));
    }   
}
