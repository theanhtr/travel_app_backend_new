<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class FilterReviewsRequest extends FormRequest
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
            'hotel_id' => 'required|numeric',
            'type_id' => 'nullable|numeric',
            'sort_by_id' => 'nullable|numeric',
            'star_rating' => "nullable|numeric|in:1,2,3,4,5",
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
