<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class FilterHotelsRequest extends FormRequest
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
            'province_id' => 'numeric',
            'district_id' => 'numeric',
            'sub_district_id' => 'numeric',
            'budget_from' => 'required|numeric',
            'budget_to' => 'required|numeric|gte:budget_from',
            'rating_average' => 'required|numeric|in:1,2,3,4,5',
            'amenities' => 'string|nullable',
            'sort_by_id' => 'numeric'
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
