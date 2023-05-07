<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreMyInformationRequest extends FormRequest
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
    public function rules(): array
    {
        return [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'phone_number' => 'numeric|unique:user_information',
                'date_of_birth' => 'date',
                'email_contact' => 'email|unique:user_information',
                'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048'
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
